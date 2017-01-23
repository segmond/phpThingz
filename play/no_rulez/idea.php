<?php
// Avoid implementing your own rule engine, first pass
//
// https://hackernoon.com/you-might-not-need-if-statements-a-better-approach-to-branching-logic-59b4f877697f#.rp1v5j8wc
class User { 
	public $signed_in = false;
	public $is_premium = false;
	public $searched = false;
	public $display = null;
	public $search_category = null;
}

class SignedInUser extends User {
	public function __construct(Display $display) {
		$this->display = $display;
		$this->signed_in = true;
	}
	public function render() {
		if ($this->signed_in) {
			if ($this->is_premium) {
				$this->display->showSupportWidget();
			} else {
				$this->display->showTipOfTheDay();
			}
		}
	}
}

class Visitor extends User {
	public function __construct(Display $display) {
		$this->display = $display;
	}
	public function render() {
		if (!$this->searched) {
			$this->display->showMainBannerAd();
		} else {
			$this->display->showAdsByCategory($this->search_category);
		}
	}
}

class Display {
	public $nappies_ad_available=true;
	public function showSupportWidget() { echo "Support Widget\n"; }
	public function showTipOfTheDay() { echo "Tip of the Day\n";}
	public function showMainBannerAd() { echo "Main Banner Ad\n"; }
	public function showAdsByCategory($search_category) { 
		//var_dump($search_category);
		switch ($search_category) {
		case 'SINGLES':
			$this->showKittenAd();
			break;
		case 'WEDDING':
			$this->showNappiesAd();
			break;
		case 'RETIREMENT':
			$this->showHolidayAd();
			break;
		}
	}
	private function showKittenAd() { echo "Kitten Ad\n"; }
	private function showNappiesAd() { 
		if ($this->nappies_ad_available) {
			echo "Nappies Ad\n";
		} else {
			$this->showMainBannerAd();
		}
	}
	private function showHolidayAd() { echo "Holiday Ad\n"; }
}

class UserTest {
	public function __construct(User $u) {
		$this->user = $u;
	}
	public function test() {
		$true_false = [true, false];
		$signed_in = $true_false;
		$is_premium = $true_false;
		$searched = $true_false;
		$search_category = ['SINGLES', 'WEDDING', 'RETIREMENT', 'FOO'];
		foreach ($signed_in as $s) {
			foreach ($is_premium as $p) {
				foreach ($searched as $se) {
					//var_dump($search_category);
					foreach ($search_category as $sc) {
						$this->user->signed_in = $s;
						$this->user->is_preimum = $p;
						$this->user->searched = $se;
						$this->user->search_category = $sc;
						//var_dump(['signed_in'=>$this->signed_in, 'premium'=>$this->is_preimum, 
						//	'searched'=>$this->searched, 'category'=>$this->search_category]);
						$this->user->render();
					}
				}
			}
		}
	}
}

// Test all possible combinations
$d = new Display();
$u = new UserTest(new SignedInUser($d));
$u->test();

$v = new UserTest(new Visitor($d));
$v->test();

$d = new Display();
$d->nappies_ad_available=false;
$v = new UserTest(new Visitor($d));
$v->test();
