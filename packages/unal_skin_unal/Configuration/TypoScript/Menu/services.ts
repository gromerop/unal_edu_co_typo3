lib.servicesMenu = HMENU
lib.servicesMenu {
    special = directory
    special.value = {$tx_unalskindefault.parameters.serviceMenuUid}

    # Enlaces del primer nivel
    1 = TMENU
    1 {
            wrap = |
            NO = 1
            NO {
ATagBeforeWrap = 1
	       wrapItemAndSub = <li>|</li>
	       wrapItemAndSub.insertData = 1
	       allWrap >
	       allWrap.insertData = 1
	       before.cObject = IMAGE
	       before.cObject.file.import = uploads/media/
	       before.cObject.file.import.field = media
	       before.cObject.file.import.listNum = 0
	       before.cObject.stdWrap.typolink.parameter.field = uid
	       beforeWrap = |
            }
    }

    # Enlaces de segundo y tercer nivel
    2 >
    3 >
}