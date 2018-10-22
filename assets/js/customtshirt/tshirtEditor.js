var canvas;
var canvas2;
var tshirts = new Array(); //prototype: [{style:'x',color:'white',front:'a',back:'b',price:{tshirt:'12.95',frontPrint:'4.99',backPrint:'4.99',total:'22.47'}}]
var a;
var b;
var line1;
var line2;
var line3;
var line4;
$(document).ready(function () {

    get_color_id('White', $("#product_id_image").val());
    get_size_id('Small', $("#product_id_image").val());
    //setup front side canvas 
    canvas = new fabric.Canvas('tcanvas', {
        hoverCursor: 'pointer',
        selection: true,
        selectionBorderColor: 'blue',
        allowTouchScrolling: false
    });

    canvas2 = new fabric.Canvas('tcanvas2', {
        hoverCursor: 'pointer',
        selection: true,
        selectionBorderColor: 'blue',
        allowTouchScrolling: false
    });
 
    canvas.on({
        'object:moving': function (e) {
            e.target.opacity = 0.5;
            e.target.disableScroll = true;
        },
        'object:modified': function (e) {
            e.target.opacity = 1;
        },
        'object:selected': onObjectSelected,
        'selection:cleared': onSelectedCleared
    });
   
    canvas2.on({
        'object:moving': function (e) {
            e.target.opacity = 0.5;
        },
        'object:modified': function (e) {
            e.target.opacity = 1;
        },
        'object:selected': onObjectSelected2,
        'selection:cleared': onSelectedCleared2
    });
    // piggyback on `canvas.findTarget`, to fire "object:over" and "object:out" events
    canvas.findTarget = (function (originalFn) {
        return function () {
            var target = originalFn.apply(this, arguments);
            if (target) {
                if (this._hoveredTarget !== target) {
                    canvas.fire('object:over', {target: target});
                    if (this._hoveredTarget) {
                        canvas.fire('object:out', {target: this._hoveredTarget});
                    }
                    this._hoveredTarget = target;
                }
            } else if (this._hoveredTarget) {
                canvas.fire('object:out', {target: this._hoveredTarget});
                this._hoveredTarget = null;
            }
            return target;
        };
    })(canvas.findTarget);

    // piggyback on `canvas.findTarget`, to fire "object:over" and "object:out" events
    canvas2.findTarget = (function (originalFn) {
        return function () {
            var target = originalFn.apply(this, arguments);
            if (target) {
                if (this._hoveredTarget !== target) {
                    canvas2.fire('object:over', {target: target});
                    if (this._hoveredTarget) {
                        canvas2.fire('object:out', {target: this._hoveredTarget});
                    }
                    this._hoveredTarget = target;
                }
            } else if (this._hoveredTarget) {
                canvas2.fire('object:out', {target: this._hoveredTarget});
                this._hoveredTarget = null;
            }
            return target;
        };
    })(canvas2.findTarget);

    canvas.on('object:over', function (e) {
        //e.target.setFill('red');
        //canvas.renderAll();
    });

    canvas2.on('object:over', function (e) {
        //e.target.setFill('red');
        //canvas.renderAll();
    });

    canvas.on('object:out', function (e) {
        //e.target.setFill('green');
        //canvas.renderAll();
    });

    canvas2.on('object:out', function (e) {
        //e.target.setFill('green');
        //canvas.renderAll();
    });

    document.getElementById('add-text').onclick = function () {
        var text = $("#text-string").val();
        var textSample = new fabric.Text(text, {
            left: fabric.util.getRandomInt(0, 100),
            top: fabric.util.getRandomInt(0, 300),
            fontFamily: 'helvetica',
            angle: 0,
            fill: '#000000',
            scaleX: 0.5,
            scaleY: 0.5,
            fontWeight: '',
            hasRotatingPoint: true
        });
        canvas.add(textSample);
        canvas.item(canvas.item.length - 1).hasRotatingPoint = true;
        $("#texteditor").css('display', 'block');
        $("#imageeditor").css('display', 'block');
    };

    document.getElementById('add-text2').onclick = function () {
        var text = $("#text-string2").val();
        var textSample = new fabric.Text(text, {
            left: fabric.util.getRandomInt(0, 100),
            top: fabric.util.getRandomInt(0, 300),
            fontFamily: 'helvetica',
            angle: 0,
            fill: '#000000',
            scaleX: 0.5,
            scaleY: 0.5,
            fontWeight: '',
            hasRotatingPoint: true
        });
        canvas2.add(textSample);
        canvas2.item(canvas2.item.length - 1).hasRotatingPoint = true;
        $("#texteditor2").css('display', 'block');
        $("#imageeditor2").css('display', 'block');
    };
    $("#text-string").keyup(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.text = this.value;
            canvas.renderAll();
        }
    });

    $("#text-string2").keyup(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.text = this.value;
            canvas2.renderAll();
        }
    });
    $(".img-polaroid").click(function (e) {
        var el = e.target;
        /*temp code*/
        var offset = 50;
        var left = fabric.util.getRandomInt(0 + offset, 20 - offset);
        var top = fabric.util.getRandomInt(0 + offset, 10 - offset);
        var angle = fabric.util.getRandomInt(-20, 40);
        var width = fabric.util.getRandomInt(30, 50);
        var opacity = (function (min, max) {
            return Math.random() * (max - min) + min;
        })(0.5, 1);



        fabric.Image.fromURL(el.src, function (image) {
            image.set({
                left: left,
                top: top,
                angle: 0,
                padding: 10,
                cornersize: 10,
                hasRotatingPoint: true,
                width: 150,
                height: 150
            });
            //image.scale(getRandomNum(0.1, 0.25)).setCoords();
            if ($("#select_front").is(":checked"))
            {
                canvas.add(image);
            }
            if ($("#select_back").is(":checked"))
            {
                canvas2.add(image);
            }
        });
    });
    document.getElementById('remove-selected').onclick = function () {
        var activeObject = canvas.getActiveObject(),
                activeGroup = canvas.getActiveGroup();
        if (activeObject) {
            canvas.remove(activeObject);
            $("#text-string").val("");
        } else if (activeGroup) {
            var objectsInGroup = activeGroup.getObjects();
            canvas.discardActiveGroup();
            objectsInGroup.forEach(function (object) {
                canvas.remove(object);
            });
        }
    };

    document.getElementById('remove-selected2').onclick = function () {
        var activeObject = canvas2.getActiveObject(),
                activeGroup = canvas2.getActiveGroup();
        if (activeObject) {
            canvas2.remove(activeObject);
            $("#text-string2").val("");
        } else if (activeGroup) {
            var objectsInGroup = activeGroup.getObjects();
            canvas2.discardActiveGroup();
            objectsInGroup.forEach(function (object) {
                canvas2.remove(object);
            });
        }
    };
    /*document.getElementById('bring-to-front').onclick = function() {		  
     var activeObject = canvas.getActiveObject(),
     activeGroup = canvas.getActiveGroup();
     if (activeObject) {
     activeObject.bringToFront();
     }
     else if (activeGroup) {
     var objectsInGroup = activeGroup.getObjects();
     canvas.discardActiveGroup();
     objectsInGroup.forEach(function(object) {
     object.bringToFront();
     });
     }
     };
     document.getElementById('send-to-back').onclick = function() {		  
     var activeObject = canvas.getActiveObject(),
     activeGroup = canvas.getActiveGroup();
     if (activeObject) {
     activeObject.sendToBack();
     }
     else if (activeGroup) {
     var objectsInGroup = activeGroup.getObjects();
     canvas.discardActiveGroup();
     objectsInGroup.forEach(function(object) {
     object.sendToBack();
     });
     }
     };	*/
    $("#text-bold").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontWeight = (activeObject.fontWeight == 'bold' ? '' : 'bold');
            canvas.renderAll();
        }
    });
    $("#text-bold2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontWeight = (activeObject.fontWeight == 'bold' ? '' : 'bold');
            canvas2.renderAll();
        }
    });
    $("#text-italic").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontStyle = (activeObject.fontStyle == 'italic' ? '' : 'italic');
            canvas.renderAll();
        }
    });
    $("#text-italic2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontStyle = (activeObject.fontStyle == 'italic' ? '' : 'italic');
            canvas2.renderAll();
        }
    });
    $("#text-strike").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textDecoration = (activeObject.textDecoration == 'line-through' ? '' : 'line-through');
            canvas.renderAll();
        }
    });
    $("#text-strike2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textDecoration = (activeObject.textDecoration == 'line-through' ? '' : 'line-through');
            canvas2.renderAll();
        }
    });
    $("#text-underline").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textDecoration = (activeObject.textDecoration == 'underline' ? '' : 'underline');
            canvas.renderAll();
        }
    });
    $("#text-underline2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textDecoration = (activeObject.textDecoration == 'underline' ? '' : 'underline');
            canvas2.renderAll();
        }
    });
    $("#text-left").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textAlign = 'left';
            canvas.renderAll();
        }
    });
    $("#text-left2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textAlign = 'left';
            canvas2.renderAll();
        }
    });
    $("#text-center").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textAlign = 'center';
            canvas.renderAll();
        }
    });
    $("#text-center2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textAlign = 'center';
            canvas2.renderAll();
        }
    });
    $("#text-right").click(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textAlign = 'right';
            canvas.renderAll();
        }
    });
    $("#text-right2").click(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.textAlign = 'right';
            canvas2.renderAll();
        }
    });
    $("#font-family").change(function () {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontFamily = this.value;
            canvas.renderAll();
        }
    });
    $("#font-family2").change(function () {
        var activeObject = canvas2.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.fontFamily = this.value;
            canvas2.renderAll();
        }
    });
    $('#text-bgcolor').miniColors({
        change: function (hex, rgb) {
            var activeObject = canvas.getActiveObject();
            if (activeObject && activeObject.type === 'text') {
                activeObject.backgroundColor = this.value;
                canvas.renderAll();
            }
        },
        open: function (hex, rgb) {
            //
        },
        close: function (hex, rgb) {
            //
        }
    });
    $('#text-bgcolor2').miniColors({
        change: function (hex, rgb) {
            var activeObject = canvas2.getActiveObject();
            if (activeObject && activeObject.type === 'text') {
                activeObject.backgroundColor = this.value;
                canvas2.renderAll();
            }
        },
        open: function (hex, rgb) {
            //
        },
        close: function (hex, rgb) {
            //
        }
    });
    $('#text-fontcolor').miniColors({
        change: function (hex, rgb) {
            var activeObject = canvas.getActiveObject();
            if (activeObject && activeObject.type === 'text') {
                activeObject.fill = this.value;
                canvas.renderAll();
            }
        },
        open: function (hex, rgb) {
            //
        },
        close: function (hex, rgb) {
            //
        }
    });

    $('#text-fontcolor2').miniColors({
        change: function (hex, rgb) {
            var activeObject = canvas2.getActiveObject();
            if (activeObject && activeObject.type === 'text') {
                activeObject.fill = this.value;
                canvas2.renderAll();
            }
        },
        open: function (hex, rgb) {
            //
        },
        close: function (hex, rgb) {
            //
        }
    });

    $('#text-strokecolor').miniColors({
        change: function (hex, rgb) {
            var activeObject = canvas.getActiveObject();
            if (activeObject && activeObject.type === 'text') {
                activeObject.strokeStyle = this.value;
                canvas.renderAll();
            }
        },
        open: function (hex, rgb) {
            //
        },
        close: function (hex, rgb) {
            //
        }
    });

    $('#text-strokecolor2').miniColors({
        change: function (hex, rgb) {
            var activeObject = canvas2.getActiveObject();
            if (activeObject && activeObject.type === 'text') {
                activeObject.strokeStyle = this.value;
                canvas2.renderAll();
            }
        },
        open: function (hex, rgb) {
            //
        },
        close: function (hex, rgb) {
            //
        }
    });

    //canvas.add(new fabric.fabric.Object({hasBorders:true,hasControls:false,hasRotatingPoint:false,selectable:false,type:'rect'}));
    $("#drawingArea").hover(
            function () {
                canvas.add(line1);
                canvas.add(line2);
                canvas.add(line3);
                canvas.add(line4);
                canvas.renderAll();
            },
            function () {
                canvas.remove(line1);
                canvas.remove(line2);
                canvas.remove(line3);
                canvas.remove(line4);
                canvas.renderAll();
            }
    );

    $("#drawingArea2").hover(
            function () {
                canvas2.add(line1);
                canvas2.add(line2);
                canvas2.add(line3);
                canvas2.add(line4);
                canvas2.renderAll();
            },
            function () {
                canvas2.remove(line1);
                canvas2.remove(line2);
                canvas2.remove(line3);
                canvas2.remove(line4);
                canvas2.renderAll();
            }
    );

    $('.color-preview').click(function () {
        var color = $(this).css("background-color");
        document.getElementById("shirtDiv").style.backgroundColor = color;
        document.getElementById("shirtDiv2").style.backgroundColor = color;
    });



    $('#show_front').click(
            function () {
                $("#show_back").show();
                $("#show_front").hide();
                $("#tshirtFacing").attr("src", "../../img/customtshirt/crew_front.png");
                b = JSON.stringify(canvas);
                canvas.clear();
                try
                {
                    var json = JSON.parse(a);
                    canvas.loadFromJSON(a);
                } catch (e)
                {
                }
                canvas.renderAll();
                setTimeout(function () {
                    canvas.calcOffset();
                }, 200, );


            });
    $('#show_back').click(
            function () {
                $("#show_back").hide();
                $("#show_front").show();
                $("#tshirtFacing").attr("src", "../../img/customtshirt/crew_back.png");
                a = JSON.stringify(canvas);
                canvas.clear();
                try
                {
                    var json = JSON.parse(b);
                    canvas.loadFromJSON(b);
                } catch (e)
                {
                }
                canvas.renderAll();
                setTimeout(function () {
                    canvas.calcOffset();
                }, 200, );




            });
    $(".clearfix button,a").tooltip();
    line1 = new fabric.Line([0, 0, 200, 0], {"stroke": "#000000", "strokeWidth": 1, hasBorders: false, hasControls: false, hasRotatingPoint: false, selectable: false});
    line2 = new fabric.Line([199, 0, 200, 399], {"stroke": "#000000", "strokeWidth": 1, hasBorders: false, hasControls: false, hasRotatingPoint: false, selectable: false});
    line3 = new fabric.Line([0, 0, 0, 400], {"stroke": "#000000", "strokeWidth": 1, hasBorders: false, hasControls: false, hasRotatingPoint: false, selectable: false});
    line4 = new fabric.Line([0, 400, 200, 399], {"stroke": "#000000", "strokeWidth": 1, hasBorders: false, hasControls: false, hasRotatingPoint: false, selectable: false});

    function handleDragStart(e) {
        [].forEach.call(images, function (img) {
            img.classList.remove('img_dragging');
        });
        this.classList.add('img_dragging');
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault(); // Necessary. Allows us to drop.
        }

        e.dataTransfer.dropEffect = 'copy'; // See the section on the DataTransfer object.
        // NOTE: comment above refers to the article (see top) -natchiketa

        return false;
    }

    function handleDragOver2(e) {
        if (e.preventDefault) {
            e.preventDefault(); // Necessary. Allows us to drop.
        }

        e.dataTransfer.dropEffect = 'copy'; // See the section on the DataTransfer object.
        // NOTE: comment above refers to the article (see top) -natchiketa

        return false;
    }
    function handleDragEnter(e) {
        // this / e.target is the current hover target.
        this.classList.add('over');
    }

    function handleDragEnter2(e) {
        // this / e.target is the current hover target.
        this.classList.add('over');
    }

    function handleDragLeave(e) {
        this.classList.remove('over'); // this / e.target is previous target element.
    }

    function handleDragLeave2(e) {
        this.classList.remove('over'); // this / e.target is previous target element.
    }


    function handleDrop(e) {
        // this / e.target is current target element.

        if (e.stopPropagation) {
            e.stopPropagation(); // stops the browser from redirecting.
        }

        var img = document.querySelector('#avatarlist img.img_dragging');

        //console.log('event: ', e);

        var newImage = new fabric.Image(img, {
            width: img.width,
            height: img.height,
            // Set the center of the new object based on the event coordinates relative
            // to the canvas container.
            left: e.layerX,
            top: e.layerY
        });
        canvas.add(newImage);

        return false;
    }

    function handleDrop2(e) {
        // this / e.target is current target element.

        if (e.stopPropagation) {
            e.stopPropagation(); // stops the browser from redirecting.
        }

        var img = document.querySelector('#avatarlist img.img_dragging');

        //console.log('event: ', e);

        var newImage = new fabric.Image(img, {
            width: img.width,
            height: img.height,
            // Set the center of the new object based on the event coordinates relative
            // to the canvas container.
            left: e.layerX,
            top: e.layerY
        });
        canvas2.add(newImage);

        return false;
    }

    function handleDragEnd(e) {
        // this/e.target is the source node.
        [].forEach.call(images, function (img) {
            img.classList.remove('img_dragging');
        });
    }

    function handleDragEnd2(e) {
        // this/e.target is the source node.
        [].forEach.call(images, function (img) {
            img.classList.remove('img_dragging');
        });
    }

    if (Modernizr.draganddrop) {
        // Browser supports HTML5 DnD.

        // Bind the event listeners for the image elements
        var images = document.querySelectorAll('#avatarlist img');
        [].forEach.call(images, function (img) {
            img.addEventListener('dragstart', handleDragStart, false);
            img.addEventListener('dragend', handleDragEnd, false);
        });
        // Bind the event listeners for the canvas
        var canvasContainer = document.getElementById('shirtDiv');
        var canvasContainer2 = document.getElementById('shirtDiv2');
        canvasContainer.addEventListener('dragenter', handleDragEnter, false);
        canvasContainer.addEventListener('dragover', handleDragOver, false);
        canvasContainer.addEventListener('dragleave', handleDragLeave, false);
        canvasContainer.addEventListener('drop', handleDrop, false);
        canvasContainer2.addEventListener('dragenter', handleDragEnter2, false);
        canvasContainer2.addEventListener('dragover', handleDragOver2, false);
        canvasContainer2.addEventListener('dragleave', handleDragLeave2, false);
        canvasContainer2.addEventListener('drop', handleDrop2, false);
    } else {
        // Replace with a fallback to a library solution.
        alert("This browser doesn't support the HTML5 Drag and Drop API.");
    }
    $("#shirtDiv2").hide();
});//doc ready


function getRandomNum(min, max) {
    return Math.random() * (max - min) + min;
}

function onObjectSelected(e) {
    var selectedObject = e.target;
    $("#text-string").val("");
    selectedObject.hasRotatingPoint = true
    if (selectedObject && selectedObject.type === 'text') {
        //display text editor	    	
        $("#texteditor").css('display', 'block');
        $("#text-string").val(selectedObject.getText());
        $('#text-fontcolor').miniColors('value', selectedObject.fill);
        $('#text-strokecolor').miniColors('value', selectedObject.strokeStyle);
        $("#imageeditor").css('display', 'block');
    } else if (selectedObject && selectedObject.type === 'image') {
        //display image editor
        $("#texteditor").css('display', 'none');
        $("#imageeditor").css('display', 'block');
    }
}
function onObjectSelected2(e) {
    var selectedObject = e.target;
    $("#text-string2").val("");
    selectedObject.hasRotatingPoint = true
    if (selectedObject && selectedObject.type === 'text') {
        //display text editor	    	
        $("#texteditor2").css('display', 'block');
        $("#text-string2").val(selectedObject.getText());
        $('#text-fontcolor2').miniColors('value', selectedObject.fill);
        $('#text-strokecolor2').miniColors('value', selectedObject.strokeStyle);
        $("#imageeditor2").css('display', 'block');
    } else if (selectedObject && selectedObject.type === 'image') {
        //display image editor
        $("#texteditor2").css('display', 'none');
        $("#imageeditor2").css('display', 'block');
    }
}
function onSelectedCleared(e) {
    $("#texteditor").css('display', 'none');
    $("#text-string").val("");
    //$("#imageeditor").css('display', 'none');
}
function onSelectedCleared2(e) {
    $("#texteditor2").css('display', 'none');
    $("#text-string2").val("");
    //$("#imageeditor").css('display', 'none');
}
function setFont2(font) {
    var activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'text') {
        activeObject.fontFamily = font;
        canvas.renderAll();
    }
}
function setFont2(font) {
    var activeObject = canvas2.getActiveObject();
    if (activeObject && activeObject.type === 'text') {
        activeObject.fontFamily = font;
        canvas2.renderAll();
    }
}
function removeWhite() {
    var activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type === 'image') {
        activeObject.filters[2] = new fabric.Image.filters.RemoveWhite({hreshold: 100, distance: 10});//0-255, 0-255
        activeObject.applyFilters(canvas.renderAll.bind(canvas));
    }
}