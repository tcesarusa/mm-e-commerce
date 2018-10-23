<!-- Footer ================================================================== -->
<div id="footerSection" style="position:relative; bottom:0; left:0; right:0;">
    <div class="container">
        <div class="row">
            <div class="span3">
                <h5>ACCOUNT </h5>
                <a href="<?php echo site_url(); ?>Sessions/login_page">YOUR ACCOUNT</a>
            </div>
            <div class="span3">
                <h5>INFORMATION</h5>
                <a href="<?php echo site_url(); ?>Home/contact">CONTACT</a>  
                <a href="<?php echo site_url(); ?>Sessions/register">REGISTRATION</a>
                <a href="<?php echo site_url(); ?>Sales/return_policy">RETURN POLICY</a>
                <a href="<?php echo site_url(); ?>Sales/terms_and_conditions">TERMS AND CONDITIONS</a>
                <a href="<?php echo site_url(); ?>Sales/privacy_policy">PRIVACY POLICY</a>


            </div>
            <div class="span3">
                <h5>OUR OFFERS</h5>
                <!--<a href="#">NEW PRODUCTS</a> 
                <a href="#">TOP SELLERS</a>  -->
                <a href="<?php echo site_url(); ?>Customer_products/special_offer">SPECIAL OFFERS</a>  


            </div>
            <!--<div id="socialMedia" class="span3 pull-right">
                <h5>SOCIAL MEDIA </h5>
                <a href="#"><img width="60" height="60" src="<?php echo base_url(); ?>assets/themes/images/facebook.png" title="facebook" alt="facebook"/></a>

            </div> -->
        </div>
        <p class="pull-right">&copy; MM-E-Commerce</p>
    </div><!-- Container End -->
</div>
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<style>
    body {
        font-family: Verdana;
    }
    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        height:32px;
    }
    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
    }

</style>
<script src="<?php echo base_url(); ?>assets/themes/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/themes/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/themes/js/google-code-prettify/prettify.js"></script>

<script src="<?php echo base_url(); ?>assets/themes/js/bootshop.js"></script>
<script src="<?php echo base_url(); ?>assets/themes/js/jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/webix/webix/codebase/webix.css" type="text/css" charset="utf-8">
<script src="<?php echo base_url(); ?>assets/js/webix/webix/codebase/webix.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/js/webix/webix/samples/common/treedata.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/webix/webix/samples/common/samples.css"> 
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112073464-2"></script>


<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-112073464-2']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-112073464-2');

    var site_url;
    var json_cat;
    var cart_price;
    var width;
    var search_url;
    var file;
    $(window).resize(function () {
        grid.define("width", $("#sideManu").width() - 2);
        grid.resize();
    });

    $(function () {



        width = $("#sideManu").width() - 2;
        site_url = '<?php echo site_url(); ?>';
        json_cat = <?php echo $category_tree; ?>;
<?php if ($this->uri->segment(2) != null) { ?>
            search_url = '<?php echo $this->uri->segment(2); ?>';
<?php } else { ?>
            search_url = '<?php echo $this->uri->segment(1); ?>';
<?php } ?>
        if (search_url == '') {
            //$("#design_tshirt").modal("toggle");
        }
        $("#shipping_rates_button").click();
        //update_color_size();

        if (search_url != 'personalized_tshirt') {
            webix.ready(function () {

                grid = webix.ui({
                    container: "datatree",
                    view: "menu",
                    layout: "y",
                    subMenuPos: "right",
                    autowidth: true,
                    width: width,
                    autoheight: true,
                    css: "custom",
                    data: json_cat,
                    on: {
                        onMenuItemClick: function (id) {

                            if (id.includes('*_product_*'))
                            {
                                id = id.split('*_product_*');
                                window.open("<?php echo site_url(); ?>Customer_products/product_details/" + id[0], "_self");
                            } else
                            {
                                id = id.split('*_category_*');
                                window.open("<?php echo site_url(); ?>Customer_products/product_categories/" + id[0], "_self");
                            }
                        }
                    },
                    type: {
                        subsign: true
                    }
                });

            });
        }

        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });
                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function () {
                var input = this.input,
                        wasOpen = false;
                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .on("mousedown", function () {
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                        .on("click", function () {
                            input.trigger("focus");
                            // Close if already visible
                            if (wasOpen) {
                                return;
                            }

                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
            },
            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },
            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });

        $("#category_search").combobox();
        //$("#client_country").combobox();
        $("#shipping_country").combobox();
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/general.js"></script>




<!-- Themes switcher section ============================================================================================= 
<div id="secectionBox">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/switch/themeswitch.css" type="text/css" media="screen" />
    <script src="<?php echo base_url(); ?>assets/themes/switch/theamswitcher.js" type="text/javascript" charset="utf-8"></script>
    <div id="themeContainer">
        <div id="hideme" class="themeTitle">Style Selector</div>
        <div class="themeName">Oregional Skin</div>
        <div class="images style">
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="bootshop"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/bootshop.png" alt="bootstrap business templates" class="active"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="businessltd"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/businessltd.png" alt="bootstrap business templates" class="active"></a>
        </div>
        <div class="themeName">Bootswatch Skins (11)</div>
        <div class="images style">
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="amelia" title="Amelia"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/amelia.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="spruce" title="Spruce"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/spruce.png" alt="bootstrap business templates" ></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="superhero" title="Superhero"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/superhero.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="cyborg"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/cyborg.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="cerulean"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/cerulean.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="journal"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/journal.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="readable"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/readable.png" alt="bootstrap business templates"></a>	
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="simplex"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/simplex.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="slate"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/slate.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="spacelab"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/spacelab.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="united"><img src="<?php echo base_url(); ?>assets/themes/switch/images/clr/united.png" alt="bootstrap business templates"></a>
            <p style="margin:0;line-height:normal;margin-left:-10px;display:none;"><small>These are just examples and you can build your own color scheme in the backend.</small></p>
        </div>
        <div class="themeName">Background Patterns </div>
        <div class="images patterns">
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern1"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern1.png" alt="bootstrap business templates" class="active"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern2"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern2.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern3"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern3.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern4"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern4.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern5"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern5.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern6"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern6.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern7"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern7.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern8"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern8.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern9"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern9.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern10"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern10.png" alt="bootstrap business templates"></a>

            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern11"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern11.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern12"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern12.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern13"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern13.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern14"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern14.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern15"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern15.png" alt="bootstrap business templates"></a>

            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern16"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern16.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern17"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern17.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern18"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern18.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern19"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern19.png" alt="bootstrap business templates"></a>
            <a href="<?php echo base_url(); ?>assets/themes/css/#" name="pattern20"><img src="<?php echo base_url(); ?>assets/themes/switch/images/pattern/pattern20.png" alt="bootstrap business templates"></a>

        </div>
    </div>
</div>
<span id="themesBtn"></span>-->
<!-- Modal -->
<div id="design_tshirt" class="modal fade" role="dialog" style="display:none;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Design your T-Shirt</h4>
            </div>
            <div class="modal-body">
                <p>Start design your T-Shirt, <a href="<?php echo site_url(); ?>Customer_products/personalized_tshirt" style="color:green; font-size:14px;"> click here</a></p>
                <img src="<?php echo base_url(); ?>assets/img/crew_front.png" style="height:100px;"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
</body>
</html>