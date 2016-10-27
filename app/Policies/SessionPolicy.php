<?php

namespace App\Policies;

use App\User;
use App\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the list of sessions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        // All logged-in users can
        return true;
    }

    /**
     * Determine whether the user can modify the owner of a session.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function overrideOwner(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can set the time of a session.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function setTime(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function view(User $user, Session $session)
    {
        //
    }

    /**
     * Determine whether the user can create sessions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->rsvp_status === 'attending';
    }

    /**
     * Determine whether the user can update the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function update(User $user, Session $session)
    {
        return $user->id === $session->user_id;
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \App\User  $user
     * @param  \App\Session  $session
     * @return mixed
     */
    public function delete(User $user, Session $session)
    {
        //
    }
}
