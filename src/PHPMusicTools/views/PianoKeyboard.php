<?php

/**
 * renders a piano keyboard, with notes indicated
 * @param  [type] $notes [description]
 * @return [type]        [description]
 */
function render($notes) {


<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        width="520px" height="100" 
        viewBox="0 0 530 100" >
<rect x="3" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="13" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_2" x="10.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect x="23" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="33" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="43" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="53" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="63" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="73" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="83" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_5" x="30.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_7" x="40.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_10" x="60.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_12" x="70.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_14" x="80.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="23" y1="75" x2="93" y2="75" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="23" y1="78" x2="23" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="93" y1="78" x2="93" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="54" y="90" fill="black">1</text>
<rect x="93" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="103" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="113" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="123" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="133" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="143" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="153" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_17" x="100.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_19" x="110.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_22" x="130.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_24" x="140.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_26" x="150.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="93" y1="15" x2="163" y2="15" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="93" y1="18" x2="93" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="163" y1="18" x2="163" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="124" y="10" fill="black">2</text>
<rect x="163" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="173" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="183" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="193" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="203" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="213" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="223" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_29" x="170.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_31" x="180.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_34" x="200.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_36" x="210.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_38" x="220.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="163" y1="75" x2="233" y2="75" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="163" y1="78" x2="163" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="233" y1="78" x2="233" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="194" y="90" fill="black">3</text>
<rect x="233" y="20" height="50" width="10" style="stroke:#888888; fill: #00ffff"></rect>
<rect x="243" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="253" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="263" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="273" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="283" y="20" height="50" width="10" style="stroke:#888888; fill: #ffff00"></rect>
<rect x="293" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_41" x="240.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_43" x="250.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_46" x="270.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_48" x="280.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_50" x="290.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="233" y1="15" x2="303" y2="15" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="233" y1="18" x2="233" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="303" y1="18" x2="303" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="264" y="10" fill="black">4</text>
<rect x="303" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="313" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="323" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="333" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="343" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="353" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="363" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_53" x="310.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_55" x="320.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_58" x="340.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_60" x="350.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_62" x="360.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="303" y1="75" x2="373" y2="75" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="303" y1="78" x2="303" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="373" y1="78" x2="373" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="334" y="90" fill="black">5</text>
<rect x="373" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="383" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="393" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="403" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="413" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="423" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="433" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_65" x="380.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_67" x="390.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_70" x="410.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_72" x="420.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_74" x="430.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="373" y1="15" x2="443" y2="15" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="373" y1="18" x2="373" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="443" y1="18" x2="443" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="404" y="10" fill="black">6</text>
<rect x="443" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="453" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="463" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="473" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="483" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="493" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect x="503" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<rect id="key_77" x="450.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_79" x="460.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_82" x="480.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_84" x="490.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<rect id="key_86" x="500.5" y="20" height="25" width="5" style="stroke:#000000; fill: #000000"></rect>
<line x1="443" y1="75" x2="513" y2="75" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="443" y1="78" x2="443" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="513" y1="78" x2="513" y2="72" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="474" y="90" fill="black">7</text>
<rect x="513" y="20" height="50" width="10" style="stroke:#888888; fill: #ffffff"></rect>
<line x1="3" y1="15" x2="23" y2="15" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="3" y1="18" x2="3" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="23" y1="18" x2="23" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="9" y="10" fill="black">0</text>
<line x1="513" y1="15" x2="523" y2="15" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="513" y1="18" x2="513" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<line x1="523" y1="18" x2="523" y2="12" style="stroke:rgb(0,0,0);stroke-width:1"/>
<text font-size="10" x="514" y="10" fill="black">8</text>
</svg>


}
