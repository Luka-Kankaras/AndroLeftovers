<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\Builder;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->where('id', '!=', auth()->id())
            ->when($request->term, function (Builder $query, $term) {
                return $query->where('first_name', 'LIKE', "%{$term}%")
                    ->orWhere('last_name', 'LIKE', "%{$term}%")
                    ->orWhere('email', 'LIKE', "%{$term}%")
                    ->orWhere('phone_number', 'LIKE', "%{$term}%");
            })
            ->latest()
            ->paginate(8)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'date_of_birth' => $user->date_of_birth->format('d.m.Y.'),
                ];
            });

        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json($user);
    }

    public function show(User $user)
    {
        $data = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'date_of_birth' => $user->date_of_birth->format('d.m.Y.'),
        ];

        return response()->json($data);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json('Ok');
    }
}
