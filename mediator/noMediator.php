<?php
/** Without mediator */
class User {
    private $groups = array();

    public function __construct($username) {
        $this->username = $username;
    }

    public function joinGroup($group) {
        $this->groups[] = $group;
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
            echo "User:$this->username belongs to $group\n";
        }
    }
}

class Group {
    private $members = array();

    public function __construct($groupname) {
        $this->groupname = $groupname;
    }

    public function addMember(User $user) {
        $this->members[] = $user;
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

$jack = new User('jack');
$larry = new User('larry');
$alex = new User('alex');

$adm = new Group('admin');
$adm->addMember($jack);
$jack->joinGroup('admin');
$adm->addMember($larry);
$adm->addMember($alex);

$adm->showMembers();

$dev = new Group('dev');
$dev->addMember($jack);
$jack->joinGroup('dev');
$dev->addMember($larry);
$dev->addMember($alex);

$dev->showMembers();

$support = new Group('support');
$support->addMember($jack);
$jack->joinGroup('support');
$support->addMember($larry);
$support->addMember($alex);

$support->showMembers();

$jack->showMemberships();

