<style>

body.page-template-template-enroller #et-main-area {
    background-color: #f3f3f3;
}

body.page-template-template-enroller #et-main-area #main-content #content-area > article {
    background-color: #f3f3f3;
}

fieldset legend {
    margin-bottom: 20px;
    margin: 0 auto;
}
table.table.table-bordered {
    margin-top: 30px;
}
.plans_list > li {
    border-bottom: 1px solid;
    margin-bottom: 10px;
    font-weight: 700;
    font-size: 16px;
}
ul.plans_list {
    padding: 0px;
}
ul.tierRates {
    padding: 0px 0px 10px 0px;
}
ul.tierRates li {
    font-size: 15px;
    line-height: 18px;
}
ul.tierRates li span.tierName {
    margin-right: 3px;
}
ul.tierRates li span.tierRate {
    float: right;
}
fieldset {
    margin-bottom: 20px;
}
.form-field label {
    display: block;
}
.form-field {
    width: 50%;
    float: left;
    /*margin-right: 20px;*/
    height: 75px;
    padding: 5px 25px;
}
.form-field input[type=text] {
    padding: 5px 10px;
    border-radius: 5px;
}
.form-field:nth-child(odd) {
    margin-right: 0px;
}
.dependent-f legend {
    /*text-align: left;*/
}
.form-flex {
    display: flex;
}
.form-flex .form-field:nth-child(odd) {
    /*margin-right: 20px;*/
}
.form-flex .form-field:last-child {
    margin-right: 0px;
}
.form-flex .form-field {
    padding: 5px 15px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}

@media (min-width: 1280px) {
    .col-md-4 {
        flex: 0 0 33.33%;
        max-width: 33.33%;
    }
}

@media (max-width: 1279px) {
    .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 30px;
    }
    .checkbox_group .form-group.col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
        margin-bottom: 10px;
    }
}

.checkbox_group .form-group.col-md-4 {
    display: flex;
}

.plans_list .col .membership_card {
    background: white;
    padding: 30px 20px;
    max-width: 400px;
    margin: auto;
    border-top: 3px solid rgba(0,0,0,.2);
    box-shadow: 2px 2px 2px #d6d7d9;
}

.membership_header {
    padding-bottom: 30px;
    margin-bottom: 30px;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
}

.membership_header .plan_name {
    min-height: 64px;
    display: table;
    width: 100%;
}

.membership_header .plan_desc {
    margin-bottom: 25px;
}

.membership_header h3 {
    color: blue;
    text-align: center;
    margin-bottom: 15px;
    line-height: 1.25;
    font-weight: 600;
    display: table-cell;
    vertical-align: middle;
    font-size: 19px;
}

.membership_header p {
    text-align: center;
    margin-top: 25px;
    min-height: 46px;
}

.membership_header button {
    margin: 15px;
    background: linear-gradient(to bottom,#139ff0 0,#007fed 100%);
    border: 1px solid #007fed;
    color: #F7F7F7;
    font-weight: 700;
    text-shadow: 0 -1px transparent;
    min-width: 150px;
    text-align: center;
    padding: 10px;
}

.membership_header button:hover {
    cursor: pointer;
}

.membership_header .round_cost {
    max-width: 150px;
    margin: auto;
    height: 150px;
    text-align: center;
    border: 3px solid #f3f3f3;
    border-radius: 100%;
    padding-top: 40px;
    background: #ffd6ff;
}

.membership_header .round_cost h2 {
    font-weight: bold;
    font-size: 33px;
}

ul.tierRates li {
    margin-bottom: 15px;
}

.d-flex {
    display: flex;
}

.checkbox_group .col {
    text-align: left;
}

.checkbox_group input, input[type='radio'] {
    width: 18px;
    height: 18px;
    position: relative;
    /*top: 2px;*/
}

.fieldset_member {
    max-width: 800px;
    margin: auto;
    border: 1px solid #b0b0b0;
    padding: 15px 10px 20px 10px;
    box-shadow: 2px 2px 2px #d6d7d9;
    margin-bottom: 30px;
}

.fieldset_member legend {
    padding-right: 10px;
    padding-left: 10px;
}

.btn_current_plan {
    background: #f3f3f3!important;
    color: black!important;
}

input[type="submit"]:hover {
    cursor: pointer;
}

input#email {
    min-width: 300px;
}

@media (max-width: 1000px) {
    .form-flex {
        display: block;
    }
}

@media (max-width: 750px) {
    #form_enroll .form-field {
        width: 100%;
    }
    input#email {
        min-width: 100%;
    }
}

#addDepBtn_d {
    display: block;
    font-size: 18px;
    padding: 10px 30px;
    background-color: black;
    color: white;
    border-radius: 30px;
    position: relative;
    margin-top: 20px;
}

#addDepBtn_v {
    display: block;
    font-size: 18px;
    padding: 10px 30px;
    background-color: black;
    color: white;
    border-radius: 30px;
    position: relative;
    margin-top: 20px;
}
</style>