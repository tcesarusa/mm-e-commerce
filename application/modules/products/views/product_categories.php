<link rel="stylesheet" href="<?php echo base_url(); ?>/js/webix/webix/codebase/webix.css" type="text/css" charset="utf-8">
<script src="<?php echo base_url(); ?>/js/webix/webix/codebase/webix.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/js/webix/webix/samples/common/treedata.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/js/webix/webix/samples/common/samples.css"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>

    .webix_tree_folder{
        background-image: url('<?php echo base_url(); ?>/images/folder_closed.png');
        background-position: 0px 4px;
        background-size: 20px 20px;
    }
    .webix_tree_folder_open{
        background-image: url('<?php echo base_url(); ?>/images/folder_opened.png');
        background-position: 0px 4px;
        background-size: 20px 20px;
    }

</style>
<script type="text/javascript">
    function show_addcategory()
    {
        if ($("#new_category").is(":visible"))
        {
            $("#new_category").hide();
        } else
        {
            $("#new_category").show();
            $("#category_name").focus();
        }
    }
    $(function () {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
                this.input.attr("placeholder", this.element.attr('placeholder'));
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

        $("#category_parent").combobox();
        $('.ui-autocomplete-input').css('width', '98%');
    });


    webix.ready(function () {
        var json_cat =<?php echo $categories ?>;
        webix.DataDriver.plainjs = webix.extend({
            arr2hash: function (data) {
                var hash = {};
                for (var i = 0; i < data.length; i++) {
                    var pid = data[i].parent_id;
                    if (!hash[pid])
                        hash[pid] = [];
                    hash[pid].push(data[i]);
                }
                return hash;
            },
            hash2tree: function (hash, level) {
                var top = hash[level];
                for (var i = 0; i < top.length; i++) {
                    var branch = top[i].id;
                    if (hash[branch])
                        top[i].data = this.hash2tree(hash, branch);
                }
                return top;
            },
            getRecords: function (data, id) {
                var hash = this.arr2hash(data);
                return this.hash2tree(hash, 0);
            }
        }, webix.DataDriver.json);

        tree = webix.ui({
            container: "datatree",
            view: "tree",
            datatype: "plainjs",
            select: "multiselect",
            height: 500,
            width: 700,
            drag: true,
            on: {
                onBeforeDrop: function (context) {
                    if (context.target) {
                        var targetItem = this.getItem(context.target);
                        context.parent = context.target;	//drop as child
                        context.index = -1; 				//as last child

                    } else {
                        return false;
                    }
                },
                "onAfterDrop": function (id, e, trg) {

                },
                //default click behavior that is true for any datatable cell
                "onItemClick": function (id, e, trg) {

                }
            },
            ready: function () {
            },
            data: json_cat

        });
    });

    function send_category()
    {
        $.post("<?php echo site_url();?>/products/add_category", 
        {
            category_name: $("#category_name").val(),
            category_parent: $("#category_parent").val()
        }).done(function (data) {
                    location.reload();
                });
    }
</script>

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('products'); ?> categories</h1>





</div>
<img src="<?php echo base_url(); ?>/images/add_blue.png" style="width:35px; margin:15px; cursor:pointer;" onclick="show_addcategory();" title="New category"/><span style="font-weight:bold;">New category</span>
<div id="new_category" class="ui-widget" style="margin:15px;" hidden>

    <input type="text" name="category_name" id="category_name" style="margin-bottom:10px;" class="form-control" placeholder="Category name">
    <br>
    <select name="category_parent" id="category_parent" class="form-control" style="width:300px;" placeholder="Select a category or type to be parent">
        <option></option>
        <?php foreach ($categories_raw as $categories_raw) { ?>
            <option value="<?php echo $categories_raw->category_id; ?>"><?php echo $categories_raw->category_name; ?></option>
        <?php } ?>
    </select>
    <button class="btn btn-success" style="margin-top:10px;" onclick="send_category();">Submit</button>


</div>
<div id="datatree" style="margin:15px; height:auto;"></div>

