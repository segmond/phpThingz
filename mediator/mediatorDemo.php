<?php
/** Without mediator */
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
        $this->groups[] = $group;
        $this->mediator->GroupAcceptsUser($this, $group);
    }

    public function leaveGroup(Group $group) {
        $key = array_search($group, $this->groups, true);
        if ($key !== false) {
            unset($this->groups[$key]);
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

    public function __construct(UserGroupMediator $mediator, $groupname) {
        $this->mediator = $mediator;
        $this->groupname = $groupname;
    }

    public function getGroupName() {
        return $this->groupname;
    }

    public function addMember(User $user) {
        $this->members[] = $user;
        $this->mediator->addUserToGroup($user, $this);
    }

    public function delMember(User $user) {
        $key = array_search($user, $this->members, true);
        if ($key !== false) {
            unset($this->members[$key]);
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
            $group->addMember($user);
        }
    }


    public function delUserFromGroup(User $user, Group $group) {
        $group->delMember($user);
        $user->leaveGroup($group->getGroupName());
    }
}


$ugMediator = new UserGroupMediator();
$jack = new User($ugMediator, 'jack');
$larry = new User($ugMediator, 'larry');
$alex = new User($ugMediator, 'alex');

$adm = new Group($ugMediator, 'admin');
$dev = new Group($ugMediator, 'dev');
$support = new Group($ugMediator, 'support');

$jack->joinGroup($adm);
$jack->joinGroup($dev);
$jack->joinGroup($support);

$support->addMember($larry);
$support->addMember($alex);


$jack->showMemberships();
$larry->showMemberships();
$alex->showMemberships();

$adm->showMembers();
$dev->showMembers();
$support->showMembers();

