<?php
/**
 *  The template for displaying Page Contact.
 *
 * @package ThemeIsle.
 *
 *    Template Name: Success
 */
session_start();

$memberId = (isset($_SESSION['memberId'])) ? $_SESSION['memberId'] : '';

get_header();
?>
</header>

<?php
if ($_POST['first_name_1']) { ?>
    <div id="main-content">
        <div class="container" style="max-width: 1500px">
            <div id="content-area" class="clearfix" style="max-width: 1200px; margin: auto">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="main_title overview_title"><?php the_title(); ?></h1>
                    <div class="overview">
                        <h4 id="report_date">Enrollee Information Report: <?= date("m/d/Y") ?></h4>
                        <h3>Primary Member</h3>
                        <div class="table_group" id="overview_primary">
                            <table>
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $_POST['first_name_1'] ?></td>
                                    <td><?= $_POST['last_name_1'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                <tr>
                                    <th>DOB</th>
                                    <th>Member ID</th>
                                    <th>Last four of SSN</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $_POST['dob_1'] ?></td>
                                    <td><?= $memberId ?></td>
                                    <td><?= $_POST['lfourssn_1'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                <tr>
                                    <th>M/F</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $_POST['gender0'] ?></td>
                                    <td><?= $_POST['phone_1'] ?></td>
                                    <td><?= $_POST['email_1'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                <tr>
                                    <th>Address1</th>
                                    <th>Address2</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $_POST['address1_1'] ?></td>
                                    <td><?= $_POST['address2_1'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                <tr>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Postal Code</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $_POST['city_1'] ?></td>
                                    <td><?= $_POST['state_1'] ?></td>
                                    <td><?= $_POST['postal_1'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($_POST['first_name_2']) { ?>
                            <h3>Spouse, Person Code: 2</h3>
                            <div class="table_group" id="overview_spouse">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $_POST['first_name_2'] ?></td>
                                        <td><?= $_POST['last_name_2'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table>
                                    <thead>
                                    <tr>
                                        <th>DOB</th>
                                        <th>M/F</th>
                                        <th>Last four of SSN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $_POST['dob_2'] ?></td>
                                        <td><?= $_POST['gender1'] ?></td>
                                        <td><?= $_POST['lfourssn_2'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>

                        <?php if ($_POST['max_code']) {
                            for ($k = 3; $k <= $_POST['max_code']; $k++) {?>
                                <h3>Child, Person Code: <?= $k?></h3>
                                <div class="table_group" id="overview_child_<?= $k?>">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?= $_POST['first_name_'.$k] ?></td>
                                            <td><?= $_POST['last_name_'.$k] ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>DOB</th>
                                            <th>M/F</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?= $_POST['dob_'.$k] ?></td>
                                            <td><?= $_POST['gender_'.$k] ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }
                        } ?>

                        <?php if ($_POST['medical_member']) {?>
                            <h3>Medical Plan</h3>
                            <div class="table_group" id="overview_spouse">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $_POST['medical_member'] ?></td>
                                        <td><?= $_POST['medical_plan_price'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php }?>

                        <?php if ($_POST['dental_member']) {?>
                            <h3>Dental Plan</h3>
                            <div class="table_group" id="overview_spouse">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $_POST['dental_member'] ?></td>
                                        <td><?= $_POST['dental_plan_price'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php }?>

                        <?php if ($_POST['vision_member']) {?>
                            <h3>Vision Plan</h3>
                            <div class="table_group" id="overview_spouse">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $_POST['vision_member'] ?></td>
                                        <td><?= $_POST['vision_plan_price'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php }?>

                    </div>
                    <div style="margin-top: 50px;text-align: center;width: 100%">
                        <button id="btn_print" onclick="window.print();"> Print </button>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <?php
} ?>

<style>
    #btn_print {
        font-size: 18px;
        padding: 10px 30px;
        background-color: #60a4da;
        color: white;
        border-radius: 30px;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        body {
            background: transparent!important;
        }
        .overview, .overview * {
            visibility: visible;
        }
        .overview {
            position: absolute;
            top: 0px;
            width: 100%;
            max-width: 1000px;
            margin: auto;
            border: none!important;
        }
        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important;  /*Firefox*/
        }
    }
</style>
<?php get_footer(); ?>
