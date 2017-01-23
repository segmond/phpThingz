<?php
// Avoid implementing your own rule engine, first pass
//
// https://hackernoon.com/you-might-not-need-if-statements-a-better-approach-to-branching-logic-59b4f877697f#.rp1v5j8wc
class User { }
class SignedInUser extends User {
	private $signed_in = false;
	private $is_premium = false;
	private $display = null;
	public function __construct(Display $display) {
		$this->display = $display;
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
	private $searched = false;
	private $display = null;
	public function __construct(Display $display) {
		$this->display = $display;
	}
	public function render() {
		if (!$this->searched) {
			$this->display->showMainBannerAd();
		} else {
			$this->display->showAdsByCategory($search_category);
		}
	}
}

class Display {
	public function showSupportWidget() { }
	public function showTipOfTheDay() { }
	public function showMainBannerAd() { }
	public function showAdsByCategory($search_category) { 
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
	private function showKittenAd() { }
	private function showNappiesAd() { 
		if ($nappies_ad_available) {
			// Nappies Ad
		} else {
			$this->showMainBannerAd();
		}
	}
	private function showHolidayAd() { }
}
