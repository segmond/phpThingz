<?php
/** User */
class User {
    private $groups = array();
    private $mediator;

    public function __construct(UserGroupMediator $mediator, $username) {
        $this->mediator = $mediator;
        $this->username = $username;
    }

    public function getUserName() {
        return $this->username;
    }

    public function joinGroup(Group $group) {
        if ($this->mediator->GroupAcceptsUser($this, $group)) {
            if (!$this->memberOf($group)) {
                $this->groups[] = $group;
            }
        }
    }

    public function leaveGroup(Group $group) {
        if ($this->memberOf($group)) {
            $key = array_search($group, $this->groups, true);
            if ($key !== false) {
                unset($this->groups[$key]);
            }
            $this->mediator->delUserFromGroup($this, $group);
        }
    }

    public function memberOf(Group $group) {
        $key = array_search($group, $this->groups, true);
        return ($key !== false) ? true : false;
    }

    public function showMemberships() {
        foreach ($this->groups as $group) {
            echo "User:$this->username belongs to " . $group->getGroupName() . "\n";
        }
    }
}

class Group {
    private $members = array();
    private $mediator;
    private $banlist = array();

    public function __construct(UserGroupMediator $mediator, $groupname) {
        $this->mediator = $mediator;
        $this->groupname = $groupname;
    }

    public function getGroupName() {
        return $this->groupname;
    }

    public function addMember(User $user) {
        if ($this->isBanned($user)) {
            return false;
        }

        if ($this->hasMember($user)) {
            return true;
        }

        $this->members[] = $user;
        $this->mediator->addUserToGroup($user, $this);
        return true;
    }

    public function delMember(User $user) {
        if ($this->hasMember($user)) {
            $key = array_search($user, $this->members, true);
            if ($key !== false) {
                unset($this->members[$key]);
            }
            $this->mediator->delUserFromGroup($user, $this);
        }
    }

    public function hasMember(User $user) {
        $key = array_search($user, $this->members, true);
        return ($key !== false) ? true : false;
    }

    public function showMembers() {
        foreach ($this->members as $user) {
            echo "Group:$this->groupname, Member:$user->username\n";
        }
    }

    public function banUser(User $user) {
        $this->banlist[] = $user;
    }

    public function isBanned(User $user) {
        $key = array_search($user, $this->banlist, true);
        return ($key !== false) ? true : false;
    }

}

class UserGroupMediator  {
    private $users = array();
    private $groups = array();

    public function addUserToGroup(User $user, Group $group) {
        $this->users[] = $user;
        $this->groups[] = $group;
        if (! $user->memberOf($group)) {
            $user->joinGroup($group);
        }
    }

    public function GroupAcceptsUser(User $user, Group $group) {
        $this->users[] = $user;
        $this->groups[] = $group;
        if (! $group->hasMember($user)) {
            return $group->addMember($user);
        }
        return true;
    }


    public function delUserFromGroup(User $user, Group $group) {
        $group->delMember($user);
        $user->leaveGroup($group);
    }
}


$ugMediator = new UserGroupMediator();
$jack = new User($ugMediator, 'jack');
$larry = new User($ugMediator, 'larry');
$alex = new User($ugMediator, 'alex');
$jerry = new User($ugMediator, 'jerry');

$adm = new Group($ugMediator, 'admin');
$dev = new Group($ugMediator, 'dev');
$support = new Group($ugMediator, 'support');

$adm->banUser($jerry);

$jack->joinGroup($adm);
$jack->joinGroup($dev);
$jack->joinGroup($support);

$support->addMember($larry);
$support->addMember($alex);

$jerry->joinGroup($adm); // shouldn't be able to join, banned
$adm->addMember($jerry); // can't join this way either

$jerry->joinGroup($support);
$jerry->joinGroup($support);
$dev->addMember($jerry);

$jack->leaveGroup($support);

$jack->showMemberships();
$larry->showMemberships();
$alex->showMemberships();
$jerry->showMemberships();

$adm->showMembers();
$dev->showMembers();
$support->showMembers();

