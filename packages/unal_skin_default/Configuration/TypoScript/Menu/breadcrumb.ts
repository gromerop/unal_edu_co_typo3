lib.breadcrumb = COA
lib.breadcrumb {
    10 = HMENU
    10 {
        special = rootline
        special.range = 0|-1
         # "not in menu pages" should show up in the breadcrumbs menu
        includeNotInMenu = 0
        excludeDoktypes = 199
        1 = TMENU
        1 {
            noBlur = 1
            # Current item should be unlinked
            CUR = 1
            target = _self
            wrap = <div class="breadcrumb-class">{$tx_unalskindefault.parameters.breadcrumbPosition}&nbsp;|</div>
            NO {
                stdWrap.field = nav_title // title
                linkWrap = ||*|&nbsp;&nbsp;/&nbsp;&nbsp;  |*|
                ATagTitle.field = nav_title // title
            }
             # Current menu item is unlinked
            CUR {
                stdWrap.field = nav_title // title
                stdWrap.wrap = <b>|</b>
                linkWrap = ||*|&nbsp;&nbsp;/&nbsp;&nbsp;|*|
                doNotLinkIt = 1
            }
        }
    }
    
    # No desplegar si se está en la página principal
    if {
        value.data = TSFE:id
        equals = 1
        negate = 1
    }
}
