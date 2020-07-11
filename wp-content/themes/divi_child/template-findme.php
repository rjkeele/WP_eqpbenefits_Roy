<?php
session_start();

get_header();
?>
    </header><!--/header-->
    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="main_title"><?php the_title(); ?></h1>
                    <div class="entry-content">
                        <div class="findme" style="width: 100%; max-width: 800px;">

                            <form method="GET" action="<?php echo site_url('find-me'); ?>">
                                <div class="row">
                                    <div class="col">Current Member ID :</div>
                                    <div class="col"><input type="text" name="memberid" required/></div>
                                </div>
                                <div class="row">
                                    <div class="col">Employee Number :</div>
                                    <div class="col"><input type="text" name="employeenumber" required/></div>
                                </div>
                                <div class="row">
                                    <div class="col">Date Of Birth :</div>
                                    <div class="col"><input type="date" name="dob" required/></div>
                                </div>
                                <div class="row">
                                    <div class="col">Last four of SSN :</div>
                                    <div class="col"><input type="text" name="ssn" required/></div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col"><input type="submit" name="submit" value="Submit"/></div>
                                </div>
                            </form>
                            <div class="search-result">
                                <?php
                                if ($_GET['memberid']) {
                                    $memberid = $_GET['memberid'];
                                    $employer = $_GET['employeenumber'];
                                    $dateofbi = date("d/m/Y", strtotime($_GET['dob']));
                                    $lfourssn = $_GET['ssn'];

                                    $xml = simplexml_load_string(file_get_contents('https://www.equipointsystems.com/gooseias/gooseias_api.php?api_key=lXzu8*lPteocEnE8C^63BV8^6qX~)K$7f0I^$gDN&action=eeid&renew_code=' . $employer . '&ssn_last_4=' . $lfourssn . '&birth_date=' . $dateofbi . '&em_memberid=' . $memberid));

                                    if ($xml->error) {
                                        $_SESSION['memberId'] = '';
                                        $_SESSION['dob'] = '';
                                        $_SESSION['lfourssn'] = '';
                                        $_SESSION['emplyeeNum'] = '';
                                        $_SESSION['xml_valid'] = '';
                                        ?>
                                        <div class="row">
                                            <div class="col headin">
                                                <?php echo ucwords($xml->error); ?>
                                            </div>

                                        </div>
                                        <?php

                                    } else {
                                        $_SESSION['memberId'] = $memberid;
                                        $_SESSION['dob'] = $dateofbi;
                                        $_SESSION['lfourssn'] = $lfourssn;
                                        $_SESSION['emplyeeNum'] = $employer;
                                        $_SESSION['xml_valid'] = 'true';

//                                        header('Location: /enroll', true);

                                        ?>
                                        <?php foreach ($xml->members as $member) {?>
                                            <div class="head_row">
                                            <?php foreach ($member->enrollee as $enrollkey => $enrollee) {
                                                ?>
                                                <div class="row">
                                                <div class="col headin">
                                                    <?php echo ucwords($enrollkey); ?>
                                                </div>
                                                <div class="col">
                                                    <?php echo $enrollee; ?>
                                                </div>
                                                </div><?php
                                                foreach ($enrollee as $enrolkey => $enrolle) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col">
                                                            <?php echo ucwords($enrolkey); ?>
                                                        </div>
                                                        <div class="col">
                                                            <?php echo $enrolle; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }?>
                                            </div>
                                            <?php foreach ($member->dependent as $dependentkey => $dependent) {
                                                ?>
                                                <div class="head_row">
                                                <div class="row">
                                                <div class="col headin">
                                                    <?php echo ucwords($dependentkey); ?>
                                                </div>
                                                <div class="col">
                                                    <?php echo $dependent; ?>
                                                </div>
                                                </div><?php
                                                foreach ($dependent as $dependenkey => $dependen) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col">
                                                            <?php echo ucwords($dependenkey); ?>
                                                        </div>
                                                        <div class="col">
                                                            <?php echo $dependen; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }?>
                                                </div>
                                            <?php }
                                        }
                                    }
                                } ?>

                            </div>

                            <div class="div_to_enroll">
                                <?php if ($_GET['memberid'] && !$xml -> error) { ?>
                                    <button id="btn_print" onclick="window.print();"> Print </button>
                                    <button id="btn_to_enroll"><a href="/enroll">Go to Enroll</a></button>
                                <?php } ?>
                            </div>
                            <style>
                                #btn_to_enroll, #btn_print {
                                    display: block;
                                    font-size: 18px;
                                    padding: 10px 30px;
                                    background-color: #60a4da;
                                    color: white;
                                    border-radius: 30px;
                                }
                                #btn_to_enroll {
                                    float: right;
                                }
                                #btn_print {
                                    float: left;
                                }
                                @media print {
                                    body * {
                                        visibility: hidden;
                                    }
                                    body {
                                        background: transparent!important;
                                    }
                                    .search-result, .search-result * {
                                        visibility: visible;
                                    }
                                    .search-result {
                                        position: absolute;
                                        top: 0px;
                                        width: 100%;
                                        max-width: 800px;
                                        margin: auto;
                                        border: none!important;
                                    }
                                    .search-result .head_row {
                                        page-break-inside: avoid!important;
                                    }
                                    .search-result .col.headin:first-child {
                                        background: black!important;
                                    }
                                    .search-result .col:first-child {
                                        background: #60a4da!important;
                                        color: #fff!important;
                                    }
                                    .search-result .col {
                                        border: 1px solid #000!important;
                                        padding: 5px!important;
                                    }
                                    * {
                                        -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                                        color-adjust: exact !important;  /*Firefox*/
                                    }
                                }
                            </style>
                        </div>
                        <div class="wrapper ef">
                            <div id="enroller-content" class="ef">
                                <?php
                                $path = get_home_path() . 'enroller_II/index.php';
                                //require( $path );
                                ?>
                            </div> <!-- /div #enroller-content -->
                        </div><!--/div .wrapper-->
                    </div> <!-- .entry-content -->
                </article> <!-- .et_pb_post -->
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>