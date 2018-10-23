<?php $this->load->view("Home/top_menu");?>
<!-- Header End====================================================================== -->

<div id="mainBody">

    <div class="container" >
        <div class="row" id='tee_setup'>



            <!-- Le styles -->
            <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/customtshirt/jquery.miniColors.css" />


            <style type="text/css">
                .footer {
                    padding: 70px 0;
                    margin-top: 70px;
                    border-top: 1px solid #E5E5E5;
                    background-color: whiteSmoke;
                }			

                .color-preview {
                    border: 1px solid #CCC;
                    margin: 2px;
                    zoom: 1;
                    vertical-align: top;
                    display: inline-block;
                    cursor: pointer;
                    overflow: hidden;
                    width: 20px;
                    height: 20px;
                }
                .rotate {  
                    -webkit-transform:rotate(90deg);
                    -moz-transform:rotate(90deg);
                    -o-transform:rotate(90deg);
                    /* filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); */
                    -ms-transform:rotate(90deg);		   
                }		
                .Arial{font-family:"Arial";}
                .Helvetica{font-family:"Helvetica";}
                .MyriadPro{font-family:"Myriad Pro";}
                .Delicious{font-family:"Delicious";}
                .Verdana{font-family:"Verdana";}
                .Georgia{font-family:"Georgia";}
                .Courier{font-family:"Courier";}
                .ComicSansMS{font-family:"Comic Sans MS";}
                .Impact{font-family:"Impact";}
                .Monaco{font-family:"Monaco";}
                .Optima{font-family:"Optima";}
                .HoeflerText{font-family:"Hoefler Text";}
                .Plaster{font-family:"Plaster";}
                .Engagement{font-family:"Engagement";}

            </style>
            </head>


            <div class="span8" style='width:auto;'>
                <section id="typography" >
                    <div class="page-header">
                        <h1>Customizing T-Shirt <div class="pull-right" style='margin-left:10px;' align="" id="imageeditor">
                                <div class="btn-group" id='actions'>										      
                                    <!--<button class="btn" id="bring-to-front" title="Bring to Front"><i class="icon-fast-backward rotate" style="height:19px;"></i></button>
                                    <button class="btn" id="send-to-back" title="Send to Back"><i class="icon-fast-forward rotate" style="height:19px;"></i></button>-->
                                    <!--<button id="show_back" type="button" class="btn "  title="Show Back View"><i class="icon-retweet" style="height:19px;"></i></button>
                                    <button id="show_front" type="button" class="btn " title="Show Front View" style="display:none;"><i class="icon-retweet" style="height:19px;"></i></button>-->
                                    <button class="btn btn-primary" id='preview_tee' style='height:32px;'>Preview</button>
                                    <button id="remove-selected" class="btn" title="Delete selected item from front">Front <i class="icon-trash" style="height:19px;"></i></button>
                                    <button id="remove-selected2" class="btn" title="Delete selected item from back">Back <i class="icon-trash" style="height:19px;"></i></button>
                                </div>
                                <img src='<?php echo base_url(); ?>img/loader_orange.gif' style='margin-left:35%; display:none; width:35px;' title='Generating Preview' id='preview_loader'/>
                            </div></h1>
                        <label id='error_image' class='alert alert-danger' style='display:none;'></label>
                    </div>

                    <!-- Headings & Paragraph Copy -->
                    <div class="row">			
                        <div class="span3" id='left_actions'>
                            <form id="client_image_form" method="POST" enctype="multipart/form-data">

                                <div class="tabbable"> <!-- Only required for left/right tabs -->
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab1" data-toggle="tab">T-Shirt Colors</a></li>				    
                                        <li><a href="#tab2" data-toggle="tab">Select your Image</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="well">
                                                <!--					      	<h3>Tee Styles</h3>-->
                                                <!--						      <p>-->
                                                Select your size
                                                <select id="size_image_id" name="size_image_id" onchange="update_color_size_custom();">   
                                                    <?php foreach ($sizes as $sizes) { ?>
                                                        <option value="<?php echo $sizes->size_id; ?>" selected="selected"><?php echo $sizes->size_name; ?></option>
                                                    <?php } ?>
                                                </select>	

                                                <input type='checkbox' name='back' onclick='show_both_sides();' id='both_sides'> Both Sides
                                                <!--						      </p>-->								
                                            </div>
                                            <div class="well">
                                                <ul class="nav">
                                                    <li class="color-preview" title="White" style="background-color:#ffffff;" onclick="get_color_id('White', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Dark Heather" style="background-color:#616161;" onclick="get_color_id('Dark Heather', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Gray" style="background-color:#f0f0f0;" onclick="get_color_id('Gray', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Charcoal" style="background-color:#5b5b5b;" onclick="get_color_id('Charcoal', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Black" style="background-color:#222222;" onclick="get_color_id('Black', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Heather Orange" style="background-color:#fc8d74;" onclick="get_color_id('Heather Orange', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Heather Dark Chocolate" style="background-color:#432d26;" onclick="get_color_id('Heather Dark Chocolate', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Salmon" style="background-color:#eead91;" onclick="get_color_id('Salmon', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Chesnut" style="background-color:#806355;" onclick="get_color_id('Chesnut', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Dark Chocolate" style="background-color:#382d21;" onclick="get_color_id('Dark Chocolate', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Citrus Yellow" style="background-color:#faef93;" onclick="get_color_id('Citrus Yellow', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Avocado" style="background-color:#aeba5e;" onclick="get_color_id('Avocado', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Kiwi" style="background-color:#8aa140;" onclick="get_color_id('Kiwi', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Irish Green" style="background-color:#1f6522;" onclick="get_color_id('Irish Green', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Scrub Green" style="background-color:#13afa2;" onclick="get_color_id('Scrub Green', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Teal Ice" style="background-color:#b8d5d7;" onclick="get_color_id('Teal Ice', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Heather Sapphire" style="background-color:#15aeda;" onclick="get_color_id('Heather Sapphire', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Sky" style="background-color:#a5def8;" onclick="get_color_id('Sky', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Antique Sapphire" style="background-color:#0f77c0;" onclick="get_color_id('Antique Sapphire', <?php echo $custom_tshirt; ?>);"></li>
                                                    <li class="color-preview" title="Heather Navy" style="background-color:#3469b7;" onclick="get_color_id('Heather Navy', <?php echo $custom_tshirt; ?>);"></li>							
                                                    <li class="color-preview" title="Cherry Red" style="background-color:#c50404;" onclick="get_color_id('Cherry Red', <?php echo $custom_tshirt; ?>);"></li>
                                                </ul>
                                            </div>			      
                                        </div>		
                                        <input type='hidden' name='product_id_image' id="product_id_image" value='<?php echo $custom_tshirt; ?>'>
                                        <input type="hidden" name="color_image_id" id="color_image_id">
                                        <input type="hidden" name="selected_color" id="selected_color">
                                        <input type="hidden" name="selected_size" id="selected_size">
                                        <div class="tab-pane" id="tab2">
                                            <div class="well">
                                                <div class="input-append"><input class="span2" type="file" name="client_image" id="client_image" style="width:200px;"><br><br>
                                                    <input class="span2" id="text-string" type="text" placeholder="add text front"><button id="add-text" class="btn" title="Add text"><i class="icon-share-alt"></i></button>
                                                    <br><br>
                                                    <input class="span2" id="text-string2" type="text" placeholder="add text back" style='display:none;'><button id="add-text2" style='display:none;' class="btn" title="Add text"><i class="icon-share-alt"></i></button>
                                                    <hr>

                                                </div>
                                                <div id="avatarlist">
                                                    <img draggable="true" style="cursor:pointer;" title="Click to Add" class="img-polaroid" id="image_added" style="width:100px; height:100px;" src="#" hidden/>
                                                    <br><input type="checkbox" name="select_front" id="select_front"> Add Image to front<br>
                                                    <span id="show_back_checkbox" hidden><input type="checkbox" name="select_back" id="select_back"> Add Image to back</span>
                                                </div>				    		
                                            </div>				      
                                        </div>
                                    </div>
                                </div>	
                            </form>

                        </div>
                        <!--	EDITOR      -->	

                        <div style='float:left;'>

                            <div id="shirtDiv" class="page" style="width: 400px; height: 430px; position: relative; background-color: rgb(255, 255, 255);">
                                <img id="tshirtFacing" src="<?php echo base_url(); ?>img/customtshirt/crew_front.png" style='float:left;'/>
                                <div id="t_shirt_border" style="position: absolute;top: 100px;left: 120px;z-index: 10;width: 155px;height: 300px; border:1px black solid;">					
                                    <canvas id="tcanvas" width=155 height="300"  style="-webkit-user-select: none; "></canvas>
                                </div>
                            </div>
                        </div>
                        <div style='float:left;'>

                            <div id="shirtDiv2" class="page" style="display:normal; width: 400px; height: 430px; position: relative; background-color: rgb(255, 255, 255);">
                                <img id="tshirtFacing2" src="<?php echo base_url(); ?>img/customtshirt/crew_back.png" style='float:left;'/>
                                <div id="t_shirt_border2" style="position: absolute;top: 100px;left: 120px;z-index: 10;width: 155px;height: 300px; border:1px black solid;">					
                                    <canvas id="tcanvas2" width=155 height="300"  style="-webkit-user-select: none; "></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="span6" style='float:left; width:100%;'>		    
                            <div align="center" style="min-height: 32px;">
                                <div class="clearfix">
                                    <div class="btn-group inline pull-left" id="texteditor" style="display:none; margin-top:10px;">	

                                        <button id="font-family" class="btn dropdown-toggle" data-toggle="dropdown" title="Font Style"><i class="icon-font" style="width:19px;height:19px;"></i></button>		                      
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="font-family-X">
                                            <li><a tabindex="-1" href="#" onclick="setFont('Arial');" class="Arial">Arial</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Helvetica');" class="Helvetica">Helvetica</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Myriad Pro');" class="MyriadPro">Myriad Pro</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Delicious');" class="Delicious">Delicious</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Verdana');" class="Verdana">Verdana</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Georgia');" class="Georgia">Georgia</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Courier');" class="Courier">Courier</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Comic Sans MS');" class="ComicSansMS">Comic Sans MS</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Impact');" class="Impact">Impact</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Monaco');" class="Monaco">Monaco</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Optima');" class="Optima">Optima</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Hoefler Text');" class="Hoefler Text">Hoefler Text</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Plaster');" class="Plaster">Plaster</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont('Engagement');" class="Engagement">Engagement</a></li>
                                        </ul>
                                        <button id="text-bold" class="btn" data-original-title="Bold"><img src="<?php echo base_url(); ?>img/customtshirt/font_bold.png" height="" width=""></button>
                                        <button id="text-italic" class="btn" data-original-title="Italic"><img src="<?php echo base_url(); ?>img/customtshirt/font_italic.png" height="" width=""></button>
                                        <button id="text-strike" class="btn" title="Strike" style=""><img src="<?php echo base_url(); ?>img/customtshirt/font_strikethrough.png" height="" width=""></button>
                                        <button id="text-underline" class="btn" title="Underline" style=""><img src="<?php echo base_url(); ?>img/customtshirt/font_underline.png"></button>
                                        <a class="btn" href="#" rel="tooltip" data-placement="top" data-original-title="Font Color"><input type="hidden" id="text-fontcolor" class="color-picker" size="7" value="#000000"></a>
                                        <!--<a class="btn" href="#" rel="tooltip" data-placement="top" data-original-title="Font Border Color"><input type="hidden" id="text-strokecolor" class="color-picker" size="7" value="#000000"></a>-->
                                          <!--- Background <input type="hidden" id="text-bgcolor" class="color-picker" size="7" value="#ffffff"> --->
                                    </div>
                                    <div class="btn-group inline pull-left" id="texteditor2" style="display:none; float:right; margin-top:10px;">	

                                        <button id="font-family2" class="btn dropdown-toggle" data-toggle="dropdown" title="Font Style"><i class="icon-font" style="width:19px;height:19px;"></i></button>		                      

                                        <ul class="dropdown-menu" role="menu" aria-labelledby="font-family-X">
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Arial');" class="Arial">Arial</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Helvetica');" class="Helvetica">Helvetica</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Myriad Pro');" class="MyriadPro">Myriad Pro</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Delicious');" class="Delicious">Delicious</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Verdana');" class="Verdana">Verdana</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Georgia');" class="Georgia">Georgia</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Courier');" class="Courier">Courier</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Comic Sans MS');" class="ComicSansMS">Comic Sans MS</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Impact');" class="Impact">Impact</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Monaco');" class="Monaco">Monaco</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Optima');" class="Optima">Optima</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Hoefler Text');" class="Hoefler Text">Hoefler Text</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Plaster');" class="Plaster">Plaster</a></li>
                                            <li><a tabindex="-1" href="#" onclick="setFont2('Engagement');" class="Engagement">Engagement</a></li>
                                        </ul>
                                        <button id="text-bold2" class="btn" data-original-title="Bold"><img src="<?php echo base_url(); ?>img/customtshirt/font_bold.png" height="" width=""></button>
                                        <button id="text-italic2" class="btn" data-original-title="Italic"><img src="<?php echo base_url(); ?>img/customtshirt/font_italic.png" height="" width=""></button>
                                        <button id="text-strike2" class="btn" title="Strike" style=""><img src="<?php echo base_url(); ?>img/customtshirt/font_strikethrough.png" height="" width=""></button>
                                        <button id="text-underline2" class="btn" title="Underline" style=""><img src="<?php echo base_url(); ?>img/customtshirt/font_underline.png"></button>
                                        <a class="btn" href="#" rel="tooltip" data-placement="top" data-original-title="Font Color"><input type="hidden" id="text-fontcolor2" class="color-picker" size="7" value="#000000"></a>
                                        <!--<a class="btn" href="#" rel="tooltip" data-placement="top" data-original-title="Font Border Color"><input type="hidden" id="text-strokecolor" class="color-picker" size="7" value="#000000"></a>-->
                                          <!--- Background <input type="hidden" id="text-bgcolor" class="color-picker" size="7" value="#ffffff"> --->
                                    </div>


                                </div>												
                            </div>					  		



                        </div>



                    </div>



            </div>

            </section> 

        </div>
        <div class='row' id='preview'>
            <table class='table table-condensed'>
                <tr><td style='border-top:0px;'>
                        <img  id='test' src='#' style=' width:600px; height:600px; display:none;' />
                    </td><td style='border-top:0px;'>
                        <img  id='test2' src='#' style='display:none; width:600px; height:600px;' />
                    </td></tr>
            </table>
            <button class='btn btn-danger' onclick='return_edition();' id='return_edition' style='display:none;'>Return to edition</button>

            <button class='btn btn-success pull-right' id='add_cart_preview' style="display:none;">Add to cart</button>
            <span class="pull-right" id="cart_qtt_preview" style='display:none;'>Quantity <input type='number' class='form-control' id='cart_qtt_preview_value' value='1' style="width:100px; margin-right:5px;"></span>
        </div> 
    </div>








</div>

</div>

<!-- Footer ================================================================== -->
<?php $this->load->view("Home/footer"); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/modernizr.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.4.0/fabric.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/customtshirt/tshirtEditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/customtshirt/jquery.miniColors.min.js"></script>


