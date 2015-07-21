<?php
/** Without mediator */
class User {
    private $groups = array();
    private $mediator;

    public function __construct(UserGroupMediator $mediator, $username) {
        $this->mediator = $mediator;
        $this->username = $username;
    }

    public function joinGroup($group) {
        $this->groups[] = $group;
        $this->mediator->GroupAcceptsUser($this, $group);
    }

    public function leaveGroup($group) {
        $key = array_search($group, $this->groups, true);
        if ($key !== false) {
            unset($this->groups[$key]);
        }
    }

    public function memberOf($group) {
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

    public function isMember(User $user) {
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

    public function addUserToGroup($user, $group) {
        $this->users[] = $user;
        $this->groups[] = $group;
        $group->addMember($user);
    }

    public function GroupAcceptsUser($user, $group) {
        $this->users[] = $user;
        $this->groups[] = $group;
        $user->joinGroup($group);
    }


    public function delUserFromGroup($user, $group) {
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
//$ugMediator->addUserToGroup($jack, $adm);
/*$ugMediator->addUserToGroup($larry, $adm);
$ugMediator->addUserToGroup($alex, $adm);
$ugMediator->addUserToGroup($jack, $dev);
$ugMediator->addUserToGroup($jack, $support);
*/

$adm->showMembers();
$jack->showMemberships();

$ugMediator->delUserFromGroup($jack, $adm);
$adm->showMembers();
$jack->showMemberships();

