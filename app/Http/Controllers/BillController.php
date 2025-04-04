<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;
use App\Mail\BillInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BillController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['guestView']);
    }

    public function index()
    {
        $user = Auth::user();
        $activeBills = $user->bills()->where('is_archived', false)->get();
        $sharedBills = $user->participations()->where('is_archived', false)->get();
        $archivedBills = $user->bills()->where('is_archived', true)->get();
        $categories = Category::all();

        return view('dashboard', compact('activeBills', 'sharedBills', 'archivedBills', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('bills.create', [
            'categories' => $categories,
            'invitation_code' => Bill::generateInvitationCode()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'invitation_code' => 'required|string|unique:bills,invitation_code'
        ]);

        try {
            // Handle category
            $category = Category::firstOrCreate(
                ['name' => $request->category],
                ['color' => '#' . dechex(rand(0x000000, 0xFFFFFF))]
            );

            // Create bill
            $bill = Bill::create([
                'name' => $validated['name'],
                'user_id' => auth()->id(),
                'category_id' => $category->id,
                'invitation_code' => $validated['invitation_code'],
                'is_archived' => false
            ]);

            return redirect()->route('bills.show', $bill)
                ->with('success', 'Bill created successfully!');
        } catch (\Exception $e) {
            \Log::error('Bill creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create bill. Please try again.');
        }
    }

    public function show(Bill $bill)
    {
        // Authorization check
        if (!auth()->user()->can('view', $bill)) {
            abort(403);
        }
    
        $categories = Category::all();
        return view('bills.show', compact('bill', 'categories'));
    }

public function edit(Bill $bill)
{
    $categories = Category::all(); // Fetch categories
    return view('bills.edit', compact('bill', 'categories'));
}
public function guestShow(Bill $bill)
{
    // Add any guest-specific logic here
    $categories = Category::all();
    return view('bills.show', compact('bill', 'categories'));
}
    public function update(Request $request, Bill $bill)
    {
        $this->authorize('update', $bill);
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bill->update($request->only('name'));

        return redirect()->route('bills.show', $bill)->with('success', 'Bill updated successfully!');
    }

    public function destroy(Bill $bill)
    {
        $this->authorize('delete', $bill);
        
        $bill->delete();
        return redirect()->route('dashboard')->with('success', 'Bill deleted successfully!');
    }

    public function archive(Bill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }
        $bill->update(['is_archived' => true]);
        return redirect()->route('dashboard');
    }

    public function unarchive(Bill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }
        $bill->update(['is_archived' => false]);
        return redirect()->route('dashboard');
    }

    public function guestView(Request $request)
    {
        $code = $request->input('invitation_code');
        $bill = Bill::where('invitation_code', $code)->first();

        if (!$bill) {
            return view('guest.join')->with('error', 'Invalid invitation code');
        }

        $guestViews = session('guest_views', 0);
        if ($guestViews >= 1) {
            return view('guest.join')->with('error', 'Daily guest view limit reached');
        }

        session(['guest_views' => $guestViews + 1]);
        return view('bills.guest-show', compact('bill'));
    }

    private function authorizeBill(Bill $bill)
    {
        $user = Auth::user();
        if ($bill->user_id !== $user->id && !$bill->participants->contains($user)) {
            abort(403);
        }
    }

    public function addParticipant(Request $request, Bill $bill)
{
    $this->authorize('update', $bill);
    
    if (auth()->user()->account_type === 'standard' && $bill->participants->count() >= 3) {
        return back()->with('error', 'Standard account limit of 3 participants per bill reached.');
    }

    $request->validate([
        'email' => 'required|email',
        'user_type' => 'required|in:guest,registered',
        'nickname' => 'required_if:user_type,guest'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && $bill->participants->contains($user)) {
        return back()->with('error', 'This user is already a participant in this bill.');
    }

    $invitation = Invitation::create([
        'bill_id' => $bill->id,
        'email' => $request->email,
        'user_type' => $request->user_type,
        'nickname' => $request->user_type === 'guest' ? $request->nickname : null,
        'token' => Str::random(60), // Make sure this matches your column name
        'expires_at' => now()->addDays(7)
    ]);

    Mail::to($request->email)->send(new BillInvitation($invitation, $bill));

    return back()->with('success', 'Invitation sent successfully!');
}

    public function regenerateCode(Bill $bill)
    {
        $this->authorize('update', $bill);
        
        $bill->update(['invitation_code' => Str::upper(Str::random(8))]);
        return back()->with('success', 'Invitation code regenerated!');
    }
    public function generateCode()
{
    return response()->json(['code' => Bill::generateInvitationCode()]);
}
}