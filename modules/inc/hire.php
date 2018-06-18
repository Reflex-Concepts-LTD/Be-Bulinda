<?php
require WPATH . "modules/classes/processor.php";
$sub = new Form_Process;
?>
<li class="l-section section">
    <div class="hire">
        <h2>You want me to do</h2>
        <form class="work-request" method="post">
            <input type="hidden" name="action" value="inquiry"/>
            <div class="work-request--options">
                <span class="options-a">
                    <input id="opt-1" name="message[]" type="checkbox" value="App UI Design">
                    <label for="opt-1">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 150 111" style="enable-background:new 0 0 150 111;" xml:space="preserve">
                            <g transform="translate(0.000000,111.000000) scale(0.100000,-0.100000)">
                                <path d="M950,705L555,310L360,505C253,612,160,700,155,700c-6,0-44-34-85-75l-75-75l278-278L550-5l475,475c261,261,475,480,475,485c0,13-132,145-145,145C1349,1100,1167,922,950,705z"/>
                            </g>
                        </svg>
                        App UI Design
                    </label>
                        <input id="opt-2" name="message[]" type="checkbox" value="Creative Design">
                    <label for="opt-2">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 150 111" style="enable-background:new 0 0 150 111;" xml:space="preserve">
                            <g transform="translate(0.000000,111.000000) scale(0.100000,-0.100000)">
                                <path d="M950,705L555,310L360,505C253,612,160,700,155,700c-6,0-44-34-85-75l-75-75l278-278L550-5l475,475c261,261,475,480,475,485c0,13-132,145-145,145C1349,1100,1167,922,950,705z"/>
                            </g>
                        </svg>
                        Creative Design
                    </label>
                            <input id="opt-3" name="message[]" type="checkbox" value="Motion Design">
                    <label for="opt-3">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 150 111" style="enable-background:new 0 0 150 111;" xml:space="preserve">
                            <g transform="translate(0.000000,111.000000) scale(0.100000,-0.100000)">
                                <path d="M950,705L555,310L360,505C253,612,160,700,155,700c-6,0-44-34-85-75l-75-75l278-278L550-5l475,475c261,261,475,480,475,485c0,13-132,145-145,145C1349,1100,1167,922,950,705z"/>
                            </g>
                        </svg>
                        Motion Design
                    </label>
                </span>
                <span class="options-b">
                    <input id="opt-4" name="message[]" type="checkbox" value="UX Design">
                    <label for="opt-4">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 150 111" style="enable-background:new 0 0 150 111;" xml:space="preserve">
                            <g transform="translate(0.000000,111.000000) scale(0.100000,-0.100000)">
                                <path d="M950,705L555,310L360,505C253,612,160,700,155,700c-6,0-44-34-85-75l-75-75l278-278L550-5l475,475c261,261,475,480,475,485c0,13-132,145-145,145C1349,1100,1167,922,950,705z"/>
                            </g>
                        </svg>
                        UI/UX Design
                    </label>
                        <input id="opt-5" name="message[]" type="checkbox" value="Webdesign">
                    <label for="opt-5">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 150 111" style="enable-background:new 0 0 150 111;" xml:space="preserve">
                            <g transform="translate(0.000000,111.000000) scale(0.100000,-0.100000)">
                                <path d="M950,705L555,310L360,505C253,612,160,700,155,700c-6,0-44-34-85-75l-75-75l278-278L550-5l475,475c261,261,475,480,475,485c0,13-132,145-145,145C1349,1100,1167,922,950,705z"/>
                            </g>
                        </svg>
                        Webdesign
                    </label>
                            <input id="opt-6" name="message[]" type="checkbox" value="Blog">
                    <label for="opt-6">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 150 111" style="enable-background:new 0 0 150 111;" xml:space="preserve">
                            <g transform="translate(0.000000,111.000000) scale(0.100000,-0.100000)">
                                <path d="M950,705L555,310L360,505C253,612,160,700,155,700c-6,0-44-34-85-75l-75-75l278-278L550-5l475,475c261,261,475,480,475,485c0,13-132,145-145,145C1349,1100,1167,922,950,705z"/>
                            </g>
                        </svg>
                        Blog Development
                    </label>
                </span>
            </div>
            <div class="work-request--information">
                <div class="information-name">
                    <input id="name" name="name" type="text" spellcheck="false" required="yes">
                    <label for="name">Name</label>
                </div>
                <div class="information-email">
                    <input id="email" name="email" type="email" spellcheck="false" required="yes">
                    <label for="email">Email</label>
                </div>
            </div>
            <input type="submit" value="Send Request">
                 <?php
                    if (!empty($_POST)) {
                        $success = $sub->execute();
                    }
                    ?>
        </form>
    </div>
</li>