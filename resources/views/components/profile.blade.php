<x-layout :doctitle="$doctitle">
    <div class="container py-md-5 container--narrow">
        <h2>
            <img class="avatar-small" src="{{ $sharedData['avatar'] }}" />
            {{ $sharedData['username'] }}
            @auth
                @if (!$sharedData['currentlyFoolowing'] && Auth::user()->username !== $sharedData['username'])
                    <livewire:addfollow :username="$sharedData['username']" />
                @endif
                @if ($sharedData['currentlyFoolowing'])
                    <livewire:removefollow :username="$sharedData['username']" />
                @endif
                @if (Auth::user()->username === $sharedData['username'])
                    <a wire:navigate class="btn btn-secondary btn-sm" href="/manage/avatar">Manage Avatar</a>
                @endif

            @endauth
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            <a wire:navigate href="/profile/{{ $sharedData['username'] }}"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == '' ? 'active' : '' }}">Posts:
                {{ $sharedData['postCount'] }}</a>
            <a wire:navigate href="/profile/{{ $sharedData['username'] }}/followers"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) === 'followers' ? 'active' : '' }}">Followers:
                {{ $sharedData['followerCount'] }}</a>
            <a wire:navigate href="/profile/{{ $sharedData['username'] }}/following"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) === 'following' ? 'active' : '' }}">Following:
                {{ $sharedData['followingCount'] }}</a>
        </div>

        <div class="profile-slot-content">
            {{ $slot }}
        </div>


    </div>
</x-layout>
