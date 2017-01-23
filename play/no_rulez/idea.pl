%- using rules
display_ad(User):-
        signed_in(User),
        display_signed_in_ad(User).

display_signed_in_ad(User).
        premium(User) -> showSupportWidget ; showTipOfDay.

display_ad(User):-
        not(signed_in(User)),
        searched(User) -> display_by_category(User) ; showMainBannerAd.

display_by_category(User):-
        adCategory(User, Category),
        displayByCategory(Category).

displayByCategory(singles):- displayKitttenAds.
displayByCategory(retirement):- displayHolidayAds.
displayByCategory(nappies):- ad_available(nappies) -> displayNappiesAd ; showMainBannerAd.
displayByCategory(other):- showMainBannerAd.

