lib.mainMenu = HMENU
lib.mainMenu {
	special = directory
	special.value = {$tx_unalskindefault.parameters.mainMenuUid}
	
	# Enlaces del primer nivel
	1 = TMENU
	1 {
		wrap = |
		expAll = 1
		NO {
			linkWrap = |
			ATagBeforeWrap = 0
			doNotLinkIt = 1
			stdWrap.htmlSpecialChars = 0
			stdWrap.cObject = CASE
			stdWrap.cObject {
				key.field = doktype
				default = TEXT
				default {
					field = nav_title//title
					htmlSpecialChars = 1
					typolink {
						parameter.field = uid
						ATagParams = class="btn btn-default dropdown-toggle"  data-toggle="dropdown"
						ATagParams.insertData = 1
					}
				}
				# Link
				3 = TEXT
				3 {
					field = nav_title//title
					htmlSpecialChars = 1
					typolink {
						ATagParams = class="btn btn-default"
						ATagParams.insertData = 1
						parameter.cObject = CASE
						parameter.cObject {
							key.field = urltype
							default = TEXT
							default.dataWrap = {field:url}
							1 = TEXT
							1.dataWrap = http://{field:url}
							2 = TEXT
							2.dataWrap = ftp://{field:url}
							3 = TEXT
							3.dataWrap = mailto:{field:url}
							4 = TEXT
							4.dataWrap = https://{field:url}
						}
					}
				}
				4 = TEXT
				4 {
					field = nav_title//title
					htmlSpecialChars = 1
					typolink {
						parameter.field = uid
						ATagParams = class="btn btn-default" 
						ATagParams.insertData = 1
					}
				}

			}
			wrapItemAndSub= <div class="btn-group item_{field:uid}">|</div>
			wrapItemAndSub.insertData = 1
			allWrap>
			allWrap.insertData = 1
		}
		# Copia los parámetros de NO (Configuración para un item normal) 
		# en IFSUB (Configuración para los items que tienen subpáginas)
		IFSUB =< .NO
		IFSUB {
			doNotLinkIt = 1
			allWrap = <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">|<span class="caret"></span></div>
			allWrap.insertData = 1
			wrapItemAndSub= <div class="btn-group item_{field:uid}">|</div>
			wrapItemAndSub.insertData = 1
		}
		CURIFSUB < .IFSUB
		CUR =< .NO
		CUR {
			allWrap>
			wrapItemAndSub= <div class="btn-group item_{field:uid}">|</div>
			wrapItemAndSub.insertData = 1
			ATagParams = class="btn btn-default dropdown-toggle"
		}
	}
	
	# Enlaces del segundo nivel
	2 = TMENU
	2 {
		expAll = 1
		wrap = <ul class="dropdown-menu">|</ul>
		NO {
			stdWrap.htmlSpecialChars = 1
			wrapItemAndSub = <li>|</li>
			ATagTitle.field = description // title
			linkWrap = |
			ATagBeforeWrap = 0
			doNotLinkIt = 1
			#
			stdWrap.htmlSpecialChars = 0
			stdWrap.cObject = CASE
			stdWrap.cObject {
				key.field = doktype
				default = TEXT
				default {
					field = nav_title//title
					htmlSpecialChars = 1
					typolink {
						parameter.field = uid
						ATagParams = class="dropdown-item"
					}
				}
				# Link
				3 = TEXT
				3 {
					field = nav_title//title
					htmlSpecialChars = 1
					typolink {
						ATagParams = class="btn btn-default"
						parameter.cObject=CASE
						parameter.cObject {
							key.field=urltype
							default=TEXT
							default.dataWrap = {field:url}
							1=TEXT
							1.dataWrap = http://{field:url}
							2=TEXT
							2.dataWrap = ftp://{field:url}
							3=TEXT
							3.dataWrap = mailto:{field:url}
							4=TEXT
							4.dataWrap = https://{field:url}
						}
					}
				}
			}
		}
	}
}