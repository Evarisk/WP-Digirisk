<?php
/**
 * Liste des pays pour avec les codes appels
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2019 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.1.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

$value = ! isset( $value ) ? 0 : $value;

?>
<select name="<?php echo esc_attr( $name ); ?>" class="list-country-calling-code form-field" style="width : <?php echo esc_attr( $width ); ?>; height : auto">
<!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
<!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
<!-- <optgroup label="Other countries">f -->
	<option data-countryCode="DZ" value="213" <?php echo ($value == 213) ? "selected" : ""; ?>>Algeria (+213)</option>
	<option data-countryCode="AD" value="376" <?php echo ($value == 376) ? "selected" : ""; ?>>Andorra (+376)</option>
	<option data-countryCode="AO" value="244" <?php echo ($value == 244) ? "selected" : ""; ?>>Angola (+244)</option>
	<option data-countryCode="AI" value="1264" <?php echo ($value == 1264) ? "selected" : ""; ?>>Anguilla (+1264)</option>
	<option data-countryCode="AG" value="1268" <?php echo ($value == 1268) ? "selected" : ""; ?>>Antigua &amp; Barbuda (+1268)</option>
	<option data-countryCode="AR" value="54" <?php echo ($value == 54) ? "selected" : ""; ?>>Argentina (+54)</option>
	<option data-countryCode="AM" value="374" <?php echo ($value == 374) ? "selected" : ""; ?>>Armenia (+374)</option>
	<option data-countryCode="AW" value="297" <?php echo ($value == 297) ? "selected" : ""; ?>>Aruba (+297)</option>
	<option data-countryCode="AU" value="61" <?php echo ($value == 61) ? "selected" : ""; ?>>Australia (+61)</option>
	<option data-countryCode="AT" value="43" <?php echo ($value == 43) ? "selected" : ""; ?>>Austria (+43)</option>
	<option data-countryCode="AZ" value="994" <?php echo ($value == 994) ? "selected" : ""; ?>>Azerbaijan (+994)</option>
	<option data-countryCode="BS" value="1242" <?php echo ($value == 1242) ? "selected" : ""; ?>>Bahamas (+1242)</option>
	<option data-countryCode="BH" value="973" <?php echo ($value == 973) ? "selected" : ""; ?>>Bahrain (+973)</option>
	<option data-countryCode="BD" value="880" <?php echo ($value == 880) ? "selected" : ""; ?>>Bangladesh (+880)</option>
	<option data-countryCode="BB" value="1246" <?php echo ($value == 1246) ? "selected" : ""; ?>>Barbados (+1246)</option>
	<option data-countryCode="BY" value="375" <?php echo ($value == 375) ? "selected" : ""; ?>>Belarus (+375)</option>
	<option data-countryCode="BE" value="32" <?php echo ($value == 32) ? "selected" : ""; ?>>Belgium (+32)</option>
	<option data-countryCode="BZ" value="501" <?php echo ($value == 501) ? "selected" : ""; ?>>Belize (+501)</option>
	<option data-countryCode="BJ" value="229" <?php echo ($value == 229) ? "selected" : ""; ?>>Benin (+229)</option>
	<option data-countryCode="BM" value="1441" <?php echo ($value == 1441) ? "selected" : ""; ?>>Bermuda (+1441)</option>
	<option data-countryCode="BT" value="975" <?php echo ($value == 975) ? "selected" : ""; ?>>Bhutan (+975)</option>
	<option data-countryCode="BO" value="591" <?php echo ($value == 591) ? "selected" : ""; ?>>Bolivia (+591)</option>
	<option data-countryCode="BA" value="387" <?php echo ($value == 387) ? "selected" : ""; ?>>Bosnia Herzegovina (+387)</option>
	<option data-countryCode="BW" value="267" <?php echo ($value == 267) ? "selected" : ""; ?>>Botswana (+267)</option>
	<option data-countryCode="BR" value="55" <?php echo ($value == 55) ? "selected" : ""; ?>>Brazil (+55)</option>
	<option data-countryCode="BN" value="673" <?php echo ($value == 673) ? "selected" : ""; ?>>Brunei (+673)</option>
	<option data-countryCode="BG" value="359" <?php echo ($value == 359) ? "selected" : ""; ?>>Bulgaria (+359)</option>
	<option data-countryCode="BF" value="226" <?php echo ($value == 226) ? "selected" : ""; ?>>Burkina Faso (+226)</option>
	<option data-countryCode="BI" value="257" <?php echo ($value == 257) ? "selected" : ""; ?>>Burundi (+257)</option>
	<option data-countryCode="KH" value="855" <?php echo ($value == 855) ? "selected" : ""; ?>>Cambodia (+855)</option>
	<option data-countryCode="CM" value="237" <?php echo ($value == 237) ? "selected" : ""; ?>>Cameroon (+237)</option>
	<option data-countryCode="CA" value="1" <?php echo ($value == 1) ? "selected" : ""; ?>>Canada (+1)</option>
	<option data-countryCode="CV" value="238" <?php echo ($value == 238) ? "selected" : ""; ?>>Cape Verde Islands (+238)</option>
	<option data-countryCode="KY" value="1345" <?php echo ($value == 1345) ? "selected" : ""; ?>>Cayman Islands (+1345)</option>
	<option data-countryCode="CF" value="236" <?php echo ($value == 236) ? "selected" : ""; ?>>Central African Republic (+236)</option>
	<option data-countryCode="CL" value="56" <?php echo ($value == 56) ? "selected" : ""; ?>>Chile (+56)</option>
	<option data-countryCode="CN" value="86" <?php echo ($value == 86) ? "selected" : ""; ?>>China (+86)</option>
	<option data-countryCode="CO" value="57" <?php echo ($value == 57) ? "selected" : ""; ?>>Colombia (+57)</option>
	<option data-countryCode="KM" value="269" <?php echo ($value == 269) ? "selected" : ""; ?>>Comoros (+269)</option>
	<option data-countryCode="CG" value="242" <?php echo ($value == 242) ? "selected" : ""; ?>>Congo (+242)</option>
	<option data-countryCode="CK" value="682" <?php echo ($value == 682) ? "selected" : ""; ?>>Cook Islands (+682)</option>
	<option data-countryCode="CR" value="506" <?php echo ($value == 506) ? "selected" : ""; ?>>Costa Rica (+506)</option>
	<option data-countryCode="HR" value="385" <?php echo ($value == 385) ? "selected" : ""; ?>>Croatia (+385)</option>
	<option data-countryCode="CU" value="53" <?php echo ($value == 53) ? "selected" : ""; ?>>Cuba (+53)</option>
	<option data-countryCode="CY" value="90392" <?php echo ($value == 90392) ? "selected" : ""; ?>>Cyprus North (+90392)</option>
	<option data-countryCode="CY" value="357" <?php echo ($value == 357) ? "selected" : ""; ?>>Cyprus South (+357)</option>
	<option data-countryCode="CZ" value="42" <?php echo ($value == 42) ? "selected" : ""; ?>>Czech Republic (+42)</option>
	<option data-countryCode="DK" value="45" <?php echo ($value == 45) ? "selected" : ""; ?>>Denmark (+45)</option>
	<option data-countryCode="DJ" value="253" <?php echo ($value == 253) ? "selected" : ""; ?>>Djibouti (+253)</option>
	<option data-countryCode="DM" value="1809" <?php echo ($value == 1809) ? "selected" : ""; ?>>Dominica (+1809)</option>
	<option data-countryCode="DO" value="1809" <?php echo ($value == 1809) ? "selected" : ""; ?>>Dominican Republic (+1809)</option>
	<option data-countryCode="EC" value="593" <?php echo ($value == 593) ? "selected" : ""; ?>>Ecuador (+593)</option>
	<option data-countryCode="EG" value="20" <?php echo ($value == 20) ? "selected" : ""; ?>>Egypt (+20)</option>
	<option data-countryCode="SV" value="503" <?php echo ($value == 503) ? "selected" : ""; ?>>El Salvador (+503)</option>
	<option data-countryCode="GQ" value="240" <?php echo ($value == 240) ? "selected" : ""; ?>>Equatorial Guinea (+240)</option>
	<option data-countryCode="ER" value="291" <?php echo ($value == 291) ? "selected" : ""; ?>>Eritrea (+291)</option>
	<option data-countryCode="EE" value="372" <?php echo ($value == 372) ? "selected" : ""; ?>>Estonia (+372)</option>
	<option data-countryCode="ET" value="251" <?php echo ($value == 251) ? "selected" : ""; ?>>Ethiopia (+251)</option>
	<option data-countryCode="FK" value="500" <?php echo ($value == 500) ? "selected" : ""; ?>>Falkland Islands (+500)</option>
	<option data-countryCode="FO" value="298" <?php echo ($value == 298) ? "selected" : ""; ?>>Faroe Islands (+298)</option>
	<option data-countryCode="FJ" value="679" <?php echo ($value == 679) ? "selected" : ""; ?>>Fiji (+679)</option>
	<option data-countryCode="FI" value="358" <?php echo ($value == 358) ? "selected" : ""; ?>>Finland (+358)</option>
	<?php if( empty( $value ) && ( $local == "fr_FR" || $local == "" ) ): ?>
		<option data-countryCode="FR" value="+33" <?php echo ($value == '+33') ? "selected" : ""; ?> data-lengthmin="9" data-lengthmax="9" selected>France (+33)</option>
	<?php else: ?>
		<option data-countryCode="FR" value="+33" <?php echo ($value == '+33') ? "selected" : ""; ?> data-lengthmin="9" data-lengthmax="9">France (+33)</option>
	<?php endif; ?>
	<option data-countryCode="GF" value="594" <?php echo ($value == 594) ? "selected" : ""; ?>>French Guiana (+594)</option>
	<option data-countryCode="PF" value="689" <?php echo ($value == 689) ? "selected" : ""; ?>>French Polynesia (+689)</option>
	<option data-countryCode="GA" value="241" <?php echo ($value == 241) ? "selected" : ""; ?>>Gabon (+241)</option>
	<option data-countryCode="GM" value="220" <?php echo ($value == 220) ? "selected" : ""; ?>>Gambia (+220)</option>
	<option data-countryCode="GE" value="7880" <?php echo ($value == 7880) ? "selected" : ""; ?>>Georgia (+7880)</option>
	<option data-countryCode="DE" value="49" <?php echo ($value == 49) ? "selected" : ""; ?>>Germany (+49)</option>
	<option data-countryCode="GH" value="233" <?php echo ($value == 233) ? "selected" : ""; ?>>Ghana (+233)</option>
	<option data-countryCode="GI" value="350" <?php echo ($value == 350) ? "selected" : ""; ?>>Gibraltar (+350)</option>
	<option data-countryCode="GR" value="30" <?php echo ($value == 30) ? "selected" : ""; ?>>Greece (+30)</option>
	<option data-countryCode="GL" value="299" <?php echo ($value == 299) ? "selected" : ""; ?>>Greenland (+299)</option>
	<option data-countryCode="GD" value="1473" <?php echo ($value == 1473) ? "selected" : ""; ?>>Grenada (+1473)</option>
	<option data-countryCode="GP" value="590" <?php echo ($value == 590) ? "selected" : ""; ?>>Guadeloupe (+590)</option>
	<option data-countryCode="GU" value="671" <?php echo ($value == 671) ? "selected" : ""; ?>>Guam (+671)</option>
	<option data-countryCode="GT" value="502" <?php echo ($value == 502) ? "selected" : ""; ?>>Guatemala (+502)</option>
	<option data-countryCode="GN" value="224" <?php echo ($value == 224) ? "selected" : ""; ?>>Guinea (+224)</option>
	<option data-countryCode="GW" value="245" <?php echo ($value == 245) ? "selected" : ""; ?>>Guinea - Bissau (+245)</option>
	<option data-countryCode="GY" value="592" <?php echo ($value == 592) ? "selected" : ""; ?>>Guyana (+592)</option>
	<option data-countryCode="HT" value="509" <?php echo ($value == 509) ? "selected" : ""; ?>>Haiti (+509)</option>
	<option data-countryCode="HN" value="504" <?php echo ($value == 504) ? "selected" : ""; ?>>Honduras (+504)</option>
	<option data-countryCode="HK" value="852" <?php echo ($value == 852) ? "selected" : ""; ?>>Hong Kong (+852)</option>
	<option data-countryCode="HU" value="36" <?php echo ($value == 36) ? "selected" : ""; ?>>Hungary (+36)</option>
	<option data-countryCode="IS" value="354" <?php echo ($value == 354) ? "selected" : ""; ?>>Iceland (+354)</option>
	<option data-countryCode="IN" value="91" <?php echo ($value == 91) ? "selected" : ""; ?>>India (+91)</option>
	<option data-countryCode="ID" value="62" <?php echo ($value == 62) ? "selected" : ""; ?>>Indonesia (+62)</option>
	<option data-countryCode="IR" value="98" <?php echo ($value == 98) ? "selected" : ""; ?>>Iran (+98)</option>
	<option data-countryCode="IQ" value="964" <?php echo ($value == 964) ? "selected" : ""; ?>>Iraq (+964)</option>
	<option data-countryCode="IE" value="353" <?php echo ($value == 353) ? "selected" : ""; ?>>Ireland (+353)</option>
	<option data-countryCode="IL" value="972" <?php echo ($value == 972) ? "selected" : ""; ?>>Israel (+972)</option>
	<option data-countryCode="IT" value="39" <?php echo ($value == 39) ? "selected" : ""; ?>>Italy (+39)</option>
	<option data-countryCode="JM" value="1876" <?php echo ($value == 1876) ? "selected" : ""; ?>>Jamaica (+1876)</option>
	<option data-countryCode="JP" value="81" <?php echo ($value == 81) ? "selected" : ""; ?>>Japan (+81)</option>
	<option data-countryCode="JO" value="962" <?php echo ($value == 962) ? "selected" : ""; ?>>Jordan (+962)</option>
	<option data-countryCode="KZ" value="7" <?php echo ($value == 7) ? "selected" : ""; ?>>Kazakhstan (+7)</option>
	<option data-countryCode="KE" value="254" <?php echo ($value == 254) ? "selected" : ""; ?>>Kenya (+254)</option>
	<option data-countryCode="KI" value="686" <?php echo ($value == 686) ? "selected" : ""; ?>>Kiribati (+686)</option>
	<option data-countryCode="KP" value="850" <?php echo ($value == 850) ? "selected" : ""; ?>>Korea North (+850)</option>
	<option data-countryCode="KR" value="82" <?php echo ($value == 82) ? "selected" : ""; ?>>Korea South (+82)</option>
	<option data-countryCode="KW" value="965" <?php echo ($value == 965) ? "selected" : ""; ?>>Kuwait (+965)</option>
	<option data-countryCode="KG" value="996" <?php echo ($value == 996) ? "selected" : ""; ?>>Kyrgyzstan (+996)</option>
	<option data-countryCode="LA" value="856" <?php echo ($value == 856) ? "selected" : ""; ?>>Laos (+856)</option>
	<option data-countryCode="LV" value="371" <?php echo ($value == 371) ? "selected" : ""; ?>>Latvia (+371)</option>
	<option data-countryCode="LB" value="961" <?php echo ($value == 961) ? "selected" : ""; ?>>Lebanon (+961)</option>
	<option data-countryCode="LS" value="266" <?php echo ($value == 266) ? "selected" : ""; ?>>Lesotho (+266)</option>
	<option data-countryCode="LR" value="231" <?php echo ($value == 231) ? "selected" : ""; ?>>Liberia (+231)</option>
	<option data-countryCode="LY" value="218" <?php echo ($value == 218) ? "selected" : ""; ?>>Libya (+218)</option>
	<option data-countryCode="LI" value="417" <?php echo ($value == 417) ? "selected" : ""; ?>>Liechtenstein (+417)</option>
	<option data-countryCode="LT" value="370" <?php echo ($value == 370) ? "selected" : ""; ?>>Lithuania (+370)</option>
	<option data-countryCode="LU" value="352" <?php echo ($value == 352) ? "selected" : ""; ?>>Luxembourg (+352)</option>
	<option data-countryCode="MO" value="853" <?php echo ($value == 853) ? "selected" : ""; ?>>Macao (+853)</option>
	<option data-countryCode="MK" value="389" <?php echo ($value == 389) ? "selected" : ""; ?>>Macedonia (+389)</option>
	<option data-countryCode="MG" value="261" <?php echo ($value == 261) ? "selected" : ""; ?>>Madagascar (+261)</option>
	<option data-countryCode="MW" value="265" <?php echo ($value == 265) ? "selected" : ""; ?>>Malawi (+265)</option>
	<option data-countryCode="MY" value="60" <?php echo ($value == 60) ? "selected" : ""; ?>>Malaysia (+60)</option>
	<option data-countryCode="MV" value="960" <?php echo ($value == 960) ? "selected" : ""; ?>>Maldives (+960)</option>
	<option data-countryCode="ML" value="223" <?php echo ($value == 223) ? "selected" : ""; ?>>Mali (+223)</option>
	<option data-countryCode="MT" value="356" <?php echo ($value == 356) ? "selected" : ""; ?>>Malta (+356)</option>
	<option data-countryCode="MH" value="692" <?php echo ($value == 692) ? "selected" : ""; ?>>Marshall Islands (+692)</option>
	<option data-countryCode="MQ" value="596" <?php echo ($value == 596) ? "selected" : ""; ?>>Martinique (+596)</option>
	<option data-countryCode="MR" value="222" <?php echo ($value == 222) ? "selected" : ""; ?>>Mauritania (+222)</option>
	<option data-countryCode="YT" value="269" <?php echo ($value == 269) ? "selected" : ""; ?>>Mayotte (+269)</option>
	<option data-countryCode="MX" value="52" <?php echo ($value == 52) ? "selected" : ""; ?>>Mexico (+52)</option>
	<option data-countryCode="FM" value="691" <?php echo ($value == 691) ? "selected" : ""; ?>>Micronesia (+691)</option>
	<option data-countryCode="MD" value="373" <?php echo ($value == 373) ? "selected" : ""; ?>>Moldova (+373)</option>
	<option data-countryCode="MC" value="377" <?php echo ($value == 377) ? "selected" : ""; ?>>Monaco (+377)</option>
	<option data-countryCode="MN" value="976" <?php echo ($value == 976) ? "selected" : ""; ?>>Mongolia (+976)</option>
	<option data-countryCode="MS" value="1664" <?php echo ($value == 1664) ? "selected" : ""; ?>>Montserrat (+1664)</option>
	<option data-countryCode="MA" value="212" <?php echo ($value == 212) ? "selected" : ""; ?>>Morocco (+212)</option>
	<option data-countryCode="MZ" value="258" <?php echo ($value == 258) ? "selected" : ""; ?>>Mozambique (+258)</option>
	<option data-countryCode="MN" value="95" <?php echo ($value == 95) ? "selected" : ""; ?>>Myanmar (+95)</option>
	<option data-countryCode="NA" value="264" <?php echo ($value == 264) ? "selected" : ""; ?>>Namibia (+264)</option>
	<option data-countryCode="NR" value="674" <?php echo ($value == 674) ? "selected" : ""; ?>>Nauru (+674)</option>
	<option data-countryCode="NP" value="977" <?php echo ($value == 977) ? "selected" : ""; ?>>Nepal (+977)</option>
	<option data-countryCode="NL" value="31" <?php echo ($value == 31) ? "selected" : ""; ?>>Netherlands (+31)</option>
	<option data-countryCode="NC" value="687" <?php echo ($value == 687) ? "selected" : ""; ?>>New Caledonia (+687)</option>
	<option data-countryCode="NZ" value="64" <?php echo ($value == 64) ? "selected" : ""; ?>>New Zealand (+64)</option>
	<option data-countryCode="NI" value="505" <?php echo ($value == 505) ? "selected" : ""; ?>>Nicaragua (+505)</option>
	<option data-countryCode="NE" value="227" <?php echo ($value == 227) ? "selected" : ""; ?>>Niger (+227)</option>
	<option data-countryCode="NG" value="234" <?php echo ($value == 234) ? "selected" : ""; ?>>Nigeria (+234)</option>
	<option data-countryCode="NU" value="683" <?php echo ($value == 683) ? "selected" : ""; ?>>Niue (+683)</option>
	<option data-countryCode="NF" value="672" <?php echo ($value == 672) ? "selected" : ""; ?>>Norfolk Islands (+672)</option>
	<option data-countryCode="NP" value="670" <?php echo ($value == 670) ? "selected" : ""; ?>>Northern Marianas (+670)</option>
	<option data-countryCode="NO" value="47" <?php echo ($value == 47) ? "selected" : ""; ?>>Norway (+47)</option>
	<option data-countryCode="OM" value="968" <?php echo ($value == 968) ? "selected" : ""; ?>>Oman (+968)</option>
	<option data-countryCode="PW" value="680" <?php echo ($value == 680) ? "selected" : ""; ?>>Palau (+680)</option>
	<option data-countryCode="PA" value="507" <?php echo ($value == 507) ? "selected" : ""; ?>>Panama (+507)</option>
	<option data-countryCode="PG" value="675" <?php echo ($value == 675) ? "selected" : ""; ?>>Papua New Guinea (+675)</option>
	<option data-countryCode="PY" value="595" <?php echo ($value == 595) ? "selected" : ""; ?>>Paraguay (+595)</option>
	<option data-countryCode="PE" value="51" <?php echo ($value == 51) ? "selected" : ""; ?>>Peru (+51)</option>
	<option data-countryCode="PH" value="63" <?php echo ($value == 63) ? "selected" : ""; ?>>Philippines (+63)</option>
	<option data-countryCode="PL" value="48" <?php echo ($value == 48) ? "selected" : ""; ?>>Poland (+48)</option>
	<option data-countryCode="PT" value="351" <?php echo ($value == 351) ? "selected" : ""; ?>>Portugal (+351)</option>
	<option data-countryCode="PR" value="1787" <?php echo ($value == 1787) ? "selected" : ""; ?>>Puerto Rico (+1787)</option>
	<option data-countryCode="QA" value="974" <?php echo ($value == 974) ? "selected" : ""; ?>>Qatar (+974)</option>
	<option data-countryCode="RE" value="262" <?php echo ($value == 262) ? "selected" : ""; ?>>Reunion (+262)</option>
	<option data-countryCode="RO" value="40" <?php echo ($value == 40) ? "selected" : ""; ?>>Romania (+40)</option>
	<option data-countryCode="RU" value="7" <?php echo ($value == 7) ? "selected" : ""; ?>>Russia (+7)</option>
	<option data-countryCode="RW" value="250" <?php echo ($value == 250) ? "selected" : ""; ?>>Rwanda (+250)</option>
	<option data-countryCode="SM" value="378" <?php echo ($value == 378) ? "selected" : ""; ?>>San Marino (+378)</option>
	<option data-countryCode="ST" value="239" <?php echo ($value == 239) ? "selected" : ""; ?>>Sao Tome &amp; Principe (+239)</option>
	<option data-countryCode="SA" value="966" <?php echo ($value == 966) ? "selected" : ""; ?>>Saudi Arabia (+966)</option>
	<option data-countryCode="SN" value="221" <?php echo ($value == 221) ? "selected" : ""; ?>>Senegal (+221)</option>
	<option data-countryCode="CS" value="381" <?php echo ($value == 381) ? "selected" : ""; ?>>Serbia (+381)</option>
	<option data-countryCode="SC" value="248" <?php echo ($value == 248) ? "selected" : ""; ?>>Seychelles (+248)</option>
	<option data-countryCode="SL" value="232" <?php echo ($value == 232) ? "selected" : ""; ?>>Sierra Leone (+232)</option>
	<option data-countryCode="SG" value="65" <?php echo ($value == 65) ? "selected" : ""; ?>>Singapore (+65)</option>
	<option data-countryCode="SK" value="421" <?php echo ($value == 421) ? "selected" : ""; ?>>Slovak Republic (+421)</option>
	<option data-countryCode="SI" value="386" <?php echo ($value == 386) ? "selected" : ""; ?>>Slovenia (+386)</option>
	<option data-countryCode="SB" value="677" <?php echo ($value == 677) ? "selected" : ""; ?>>Solomon Islands (+677)</option>
	<option data-countryCode="SO" value="252" <?php echo ($value == 252) ? "selected" : ""; ?>>Somalia (+252)</option>
	<option data-countryCode="ZA" value="27" <?php echo ($value == 27) ? "selected" : ""; ?>>South Africa (+27)</option>
	<option data-countryCode="ES" value="34" <?php echo ($value == 34) ? "selected" : ""; ?>>Spain (+34)</option>
	<option data-countryCode="LK" value="94" <?php echo ($value == 94) ? "selected" : ""; ?>>Sri Lanka (+94)</option>
	<option data-countryCode="SH" value="290" <?php echo ($value == 290) ? "selected" : ""; ?>>St. Helena (+290)</option>
	<option data-countryCode="KN" value="1869" <?php echo ($value == 1869) ? "selected" : ""; ?>>St. Kitts (+1869)</option>
	<option data-countryCode="SC" value="1758" <?php echo ($value == 1758) ? "selected" : ""; ?>>St. Lucia (+1758)</option>
	<option data-countryCode="SD" value="249" <?php echo ($value == 249) ? "selected" : ""; ?>>Sudan (+249)</option>
	<option data-countryCode="SR" value="597" <?php echo ($value == 597) ? "selected" : ""; ?>>Suriname (+597)</option>
	<option data-countryCode="SZ" value="268" <?php echo ($value == 268) ? "selected" : ""; ?>>Swaziland (+268)</option>
	<option data-countryCode="SE" value="46" <?php echo ($value == 46) ? "selected" : ""; ?>>Sweden (+46)</option>
	<option data-countryCode="CH" value="41" <?php echo ($value == 41) ? "selected" : ""; ?>>Switzerland (+41)</option>
	<option data-countryCode="SI" value="963" <?php echo ($value == 963) ? "selected" : ""; ?>>Syria (+963)</option>
	<option data-countryCode="TW" value="886" <?php echo ($value == 886) ? "selected" : ""; ?>>Taiwan (+886)</option>
	<option data-countryCode="TJ" value="7" <?php echo ($value == 7) ? "selected" : ""; ?>>Tajikstan (+7)</option>
	<option data-countryCode="TH" value="66" <?php echo ($value == 66) ? "selected" : ""; ?>>Thailand (+66)</option>
	<option data-countryCode="TG" value="228" <?php echo ($value == 228) ? "selected" : ""; ?>>Togo (+228)</option>
	<option data-countryCode="TO" value="676" <?php echo ($value == 676) ? "selected" : ""; ?>>Tonga (+676)</option>
	<option data-countryCode="TT" value="1868" <?php echo ($value == 1868) ? "selected" : ""; ?>>Trinidad &amp; Tobago (+1868)</option>
	<option data-countryCode="TN" value="216" <?php echo ($value == 216) ? "selected" : ""; ?>>Tunisia (+216)</option>
	<option data-countryCode="TR" value="90" <?php echo ($value == 90) ? "selected" : ""; ?>>Turkey (+90)</option>
	<option data-countryCode="TM" value="7" <?php echo ($value == 7) ? "selected" : ""; ?>>Turkmenistan (+7)</option>
	<option data-countryCode="TM" value="993" <?php echo ($value == 993) ? "selected" : ""; ?>>Turkmenistan (+993)</option>
	<option data-countryCode="TC" value="1649" <?php echo ($value == 1649) ? "selected" : ""; ?>>Turks &amp; Caicos Islands (+1649)</option>
	<option data-countryCode="TV" value="688" <?php echo ($value == 688) ? "selected" : ""; ?>>Tuvalu (+688)</option>
	<option data-countryCode="UG" value="256" <?php echo ($value == 256) ? "selected" : ""; ?>>Uganda (+256)</option>
	<?php if( empty( $value ) && $local == "en_GB" ): ?>
		<option data-countryCode="GB" value="44" <?php echo ($value == 44) ? "selected" : ""; ?> data-lengthmin="7" data-lengthmax="10" selected>UK (+44)</option>
	<?php else: ?>
		<option data-countryCode="GB" value="44" <?php echo ($value == 44) ? "selected" : ""; ?> data-lengthmin="7" data-lengthmax="10">UK (+44)</option>
	<?php endif; ?>
	<option data-countryCode="UA" value="380" <?php echo ($value == 380) ? "selected" : ""; ?>>Ukraine (+380)</option>
	<option data-countryCode="AE" value="971" <?php echo ($value == 971) ? "selected" : ""; ?>>United Arab Emirates (+971)</option>
	<option data-countryCode="UY" value="598" <?php echo ($value == 598) ? "selected" : ""; ?>>Uruguay (+598)</option>
	<option data-countryCode="US" value="1" <?php echo ($value == 1) ? "selected" : ""; ?>>USA (+1)</option>
	<option data-countryCode="UZ" value="7" <?php echo ($value == 7) ? "selected" : ""; ?>>Uzbekistan (+7)</option>
	<option data-countryCode="VU" value="678" <?php echo ($value == 678) ? "selected" : ""; ?>>Vanuatu (+678)</option>
	<option data-countryCode="VA" value="379" <?php echo ($value == 379) ? "selected" : ""; ?>>Vatican City (+379)</option>
	<option data-countryCode="VE" value="58" <?php echo ($value == 58) ? "selected" : ""; ?>>Venezuela (+58)</option>
	<option data-countryCode="VN" value="84" <?php echo ($value == 84) ? "selected" : ""; ?>>Vietnam (+84)</option>
	<option data-countryCode="VG" value="84" <?php echo ($value == 84) ? "selected" : ""; ?>>Virgin Islands - British (+1284)</option>
	<option data-countryCode="VI" value="84" <?php echo ($value == 84) ? "selected" : ""; ?>>Virgin Islands - US (+1340)</option>
	<option data-countryCode="WF" value="681" <?php echo ($value == 681) ? "selected" : ""; ?>>Wallis &amp; Futuna (+681)</option>
	<option data-countryCode="YE" value="969" <?php echo ($value == 969) ? "selected" : ""; ?>>Yemen (North)(+969)</option>
	<option data-countryCode="YE" value="967" <?php echo ($value == 967) ? "selected" : ""; ?>>Yemen (South)(+967)</option>
	<option data-countryCode="ZM" value="260" <?php echo ($value == 260) ? "selected" : ""; ?>>Zambia (+260)</option>
	<option data-countryCode="ZW" value="263" <?php echo ($value == 263) ? "selected" : ""; ?>>Zimbabwe (+263)</option>
<!-- </optgroup> -->
</select>
