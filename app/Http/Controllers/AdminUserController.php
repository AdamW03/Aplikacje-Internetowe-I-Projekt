<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $users = $query->paginate(25);

        return view('admin.index', compact('users'));
    }

    public function ban(Request $request, User $user)
    {
        $user->is_banned = true;
        $user->save();

        return back()->with('success', 'User banned successfully');
    }


    public function unban(Request $request, User $user)
    {
        $user->is_banned = false;
        $user->save();
        return back()->with('success', 'User unbanned successfully');
    }
}
