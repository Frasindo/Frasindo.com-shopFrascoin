/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
$(function() {
    'use strict'

    /**
     * Get access to plugins
     */

    $('[data-toggle="control-sidebar"]').controlSidebar()
    $('[data-toggle="push-menu"]').pushMenu()

    var $pushMenu = $('[data-toggle="push-menu"]').data('lte.pushmenu')
    var $controlSidebar = $('[data-toggle="control-sidebar"]').data('lte.controlsidebar')
    var $layout = $('body').data('lte.layout')

    /**
     * List of all the available skins
     *
     * @type Array
     */
    var mySkins = [
        'skin-blue',
        'skin-black',
        'skin-red',
        'skin-yellow',
        'skin-purple',
        'skin-green',
        'skin-blue-light',
        'skin-black-light',
        'skin-red-light',
        'skin-yellow-light',
        'skin-purple-light',
        'skin-green-light'
    ]

    /**
     * Get a prestored setting
     *
     * @param String name Name of of the setting
     * @returns String The value of the setting | null
     */
    function get(name) {
        if (typeof(Storage) !== 'undefined') {
            return localStorage.getItem(name)
        } else {
            window.alert('Please use a modern browser to properly view this template!')
        }
    }

    /**
     * Store a new settings in the browser
     *
     * @param String name Name of the setting
     * @param String val Value of the setting
     * @returns void
     */
    function store(name, val) {
        if (typeof(Storage) !== 'undefined') {
            localStorage.setItem(name, val)
        } else {
            window.alert('Please use a modern browser to properly view this template!')
        }
    }

    /**
     * Toggles layout classes
     *
     * @param String cls the layout class to toggle
     * @returns void
     */
    function changeLayout(cls) {
        $('body').toggleClass(cls)
        $layout.fixSidebar()
        if ($('body').hasClass('fixed') && cls == 'fixed') {
            $pushMenu.expandOnHover()
            $layout.activate()
        }
        $controlSidebar.fix()
    }

    /**
     * Replaces the old skin with the new skin
     * @param String cls the new skin class
     * @returns Boolean false to prevent link's default action
     */
    function changeSkin(cls) {
        $.each(mySkins, function(i) {
            $('body').removeClass(mySkins[i])
        })

        $('body').addClass(cls)
        store('skin', cls)
        return false
    }

    /**
     * Retrieve default settings and apply them to the template
     *
     * @returns void
     */
    function setup() {
        var tmp = get('skin')
        if (tmp && $.inArray(tmp, mySkins))
            changeSkin(tmp)

        // Add the change skin listener
        $('[data-skin]').on('click', function(e) {
            if ($(this).hasClass('knob'))
                return
            e.preventDefault()
            changeSkin($(this).data('skin'))
        })

        // Add the layout manager
        $('[data-layout]').on('click', function() {
            changeLayout($(this).data('layout'))
        })

        $('[data-controlsidebar]').on('click', function() {
            changeLayout($(this).data('controlsidebar'))
            var slide = !$controlSidebar.options.slide

            $controlSidebar.options.slide = slide
            if (!slide)
                $('.control-sidebar').removeClass('control-sidebar-open')
        })

        $('[data-sidebarskin="toggle"]').on('click', function() {
            var $sidebar = $('.control-sidebar')
            if ($sidebar.hasClass('control-sidebar-dark')) {
                $sidebar.removeClass('control-sidebar-dark')
                $sidebar.addClass('control-sidebar-light')
            } else {
                $sidebar.removeClass('control-sidebar-light')
                $sidebar.addClass('control-sidebar-dark')
            }
        })

        $('[data-enable="expandOnHover"]').on('click', function() {
            $(this).attr('disabled', true)
            $pushMenu.expandOnHover()
            if (!$('body').hasClass('sidebar-collapse'))
                $('[data-layout="sidebar-collapse"]').click()
        })

        //  Reset options
        if ($('body').hasClass('fixed')) {
            $('[data-layout="fixed"]').attr('checked', 'checked')
        }
        if ($('body').hasClass('layout-boxed')) {
            $('[data-layout="layout-boxed"]').attr('checked', 'checked')
        }
        if ($('body').hasClass('sidebar-collapse')) {
            $('[data-layout="sidebar-collapse"]').attr('checked', 'checked')
        }

    }

    // Create the new tab
    var $tabPane = $('<div />', {
        'id': 'control-sidebar-theme-demo-options-tab',
        'class': 'tab-pane active'
    })

    // Create the tab button
    var $tabButton = $('<li />', { 'class': 'active' })
        .html('<a href=\'#control-sidebar-theme-demo-options-tab\' data-toggle=\'tab\'>' +
            '<i class="fa fa-wrench"></i>' +
            '</a>')

    // Add the tab button to the right sidebar tabs
    $('[href="#control-sidebar-home-tab"]')
        .parent()
        .before($tabButton)

    // Create the menu
    var $demoSettings = $('<div />')

    // Layout options
    $demoSettings.append(
        '<h4 class="control-sidebar-heading">' +
        'Layout Options' +
        '</h4>'
        // Fixed layout
        +
        '<div class="form-group">' +
        '<label class="control-sidebar-subheading">' +
        '<input type="checkbox"data-layout="fixed"class="pull-right"/> ' +
        'Fixed layout' +
        '</label>' +
        '<p>Activate the fixed layout. You can\'t use fixed and boxed layouts together</p>' +
        '</div>'
        // Boxed layout
        +
        '<div class="form-group">' +
        '<label class="control-sidebar-subheading">' +
        '<input type="checkbox"data-layout="layout-boxed" class="pull-right"/> ' +
        'Boxed Layout' +
        '</label>' +
        '<p>Activate the boxed layout</p>' +
        '</div>'
        // Sidebar Toggle
        +
        '<div class="form-group">' +
        '<label class="control-sidebar-subheading">' +
        '<input type="checkbox"data-layout="sidebar-collapse"class="pull-right"/> ' +
        'Toggle Sidebar' +
        '</label>' +
        '<p>Toggle the left sidebar\'s state (open or collapse)</p>' +
        '</div>'
        // Sidebar mini expand on hover toggle
        +
        '<div class="form-group">' +
        '<label class="control-sidebar-subheading">' +
        '<input type="checkbox"data-enable="expandOnHover"class="pull-right"/> ' +
        'Sidebar Expand on Hover' +
        '</label>' +
        '<p>Let the sidebar mini expand on hover</p>' +
        '</div>'
        // Control Sidebar Toggle
        +
        '<div class="form-group">' +
        '<label class="control-sidebar-subheading">' +
        '<input type="checkbox"data-controlsidebar="control-sidebar-open"class="pull-right"/> ' +
        'Toggle Right Sidebar Slide' +
        '</label>' +
        '<p>Toggle between slide over content and push content effects</p>' +
        '</div>'
        // Control Sidebar Skin Toggle
        +
        '<div class="form-group">' +
        '<label class="control-sidebar-subheading">' +
        '<input type="checkbox"data-sidebarskin="toggle"class="pull-right"/> ' +
        'Toggle Right Sidebar Skin' +
        '</label>' +
        '<p>Toggle between dark and light skins for the right sidebar</p>' +
        '</div>'
    )
    var $skinsList = $('<ul />', { 'class': 'list-unstyled clearfix' })

    // Dark sidebar skins
    var $skinBlue =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin">Blue</p>')
    $skinsList.append($skinBlue)
    var $skinBlack =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin">Black</p>')
    $skinsList.append($skinBlack)
    var $skinPurple =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin">Purple</p>')
    $skinsList.append($skinPurple)
    var $skinGreen =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin">Green</p>')
    $skinsList.append($skinGreen)
    var $skinRed =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin">Red</p>')
    $skinsList.append($skinRed)
    var $skinYellow =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin">Yellow</p>')
    $skinsList.append($skinYellow)

    // Light sidebar skins
    var $skinBlueLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin" style="font-size: 12px">Blue Light</p>')
    $skinsList.append($skinBlueLight)
    var $skinBlackLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin" style="font-size: 12px">Black Light</p>')
    $skinsList.append($skinBlackLight)
    var $skinPurpleLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin" style="font-size: 12px">Purple Light</p>')
    $skinsList.append($skinPurpleLight)
    var $skinGreenLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin" style="font-size: 12px">Green Light</p>')
    $skinsList.append($skinGreenLight)
    var $skinRedLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin" style="font-size: 12px">Red Light</p>')
    $skinsList.append($skinRedLight)
    var $skinYellowLight =
        $('<li />', { style: 'float:left; width: 33.33333%; padding: 5px;' })
        .append('<a href="javascript:void(0)" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">' +
            '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>' +
            '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>' +
            '</a>' +
            '<p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>')
    $skinsList.append($skinYellowLight)

    $demoSettings.append('<h4 class="control-sidebar-heading">Skins</h4>')
    $demoSettings.append($skinsList)

    $tabPane.append($demoSettings)
    $('#control-sidebar-home-tab').after($tabPane)

    setup()

    $('[data-toggle="tooltip"]').tooltip()

    var myElem = document.getElementById('dollar_class');
    if (myElem != null) {
        $(function() {
        	var timedata;
        	$.ajax({
      			url : base_url + "rest/getDate",
      			type : "get",
      			async: false,
      			success : function(data) {
         				timedata = data;
      			}
		 	    });
        	var target_date = new Date(timedata.time).getTime();
          var cu_date = new Date(timedata.curdate).getTime();
          getFixed();
          if(target_date <= cu_date)
          {
            var ht = document.getElementById('countdown');
            ht.innerHTML = "END CROWDSALE";
          }else{
            var days, hours, minutes, seconds;
         	 	var countdown = document.getElementById('countdown');
          	var interval = setInterval(function () {
              var current_date = new Date().getTime();
              var seconds_left = (target_date - current_date) / 1000;
              days = parseInt(seconds_left / 86400);
              seconds_left = seconds_left % 86400;
              hours = parseInt(seconds_left / 3600);
              seconds_left = seconds_left % 3600;
              minutes = parseInt(seconds_left / 60);
              seconds = parseInt(seconds_left % 60);
              countdown.innerHTML = days +  ':' + hours + ':'+ minutes +" <br> <span class='label label-info'>Market is "+timedata.type+"</span>";
              $("#bonusStage").html(timedata.bonus);
              }, 1000);
          }
     	   	setInterval(function () {
              getData();
			}, 10000);
        });
        $(".allacc").click(function() {
            setTimeout(function() {
                $.get(base_url + "rest/showAllTrx", function(data) {
                    console.log("Log : ");
                    console.log(data);
                    var trx = "";
                    var btcTotal = 0;
                    for (var i = 0; i < data.length; i++) {
                        var no = i + 1;
                        console.log("Data : ");
                        console.log(data[i]);
                        var time = new Date(data[i].create_at);
                        trx += "<tr>";
                        trx += "<td>" + no + "</td>";
                        trx += "<td>" + data[i].account + "</td>";
                        trx += "<td>" + data[i].amount + "</td>";
                        trx += "<td>" + data[i].details + "</td>";
                        trx += "<td>" + time.getDate() + "/" + time.getMonth() + "/" + time.getFullYear() + " "+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds()+"</td>";
                        trx += "<td><a href='https://blockchain.info/tx/" + data[i].hash + "' class='btn btn-success'>Show Details Trx</a> <span class='label label-info'>" + data[i].status + "</span></td>";
                        trx += "</tr>";
                        btcTotal = parseFloat(btcTotal) + parseFloat(data[i].amount);
                    }
                    $("#btctotalAll").html(btcTotal);
                    $("#trxAll").html(trx);
                });
            }, 500);
        });
        $(".myaccount").click(function() {
            setTimeout(function() {
                $.get(base_url + "rest/showTrx", function(data) {
                    var trx = "";
                    var btcTotal = 0;
                    var frsTotal = 0;
                    var frs = 0;
                    var frasBonus = 0;
                    for (var i = 0; i < data.data.length; i++) {
                        var no = i + 1;
                        if(data.data[i].amount.amount > 0 && ("network" in data.data[i]))
                        {
                            var time = new Date(data.data[i].created_at);
                            var statusLabel = "";
                          	if(("network" in data.data[i]))
                            {
                            if (data.data[i].status == "completed") {
                                statusLabel = "success";
                            } else {
                                statusLabel = "danger";
                            }
                            }
                            trx += "<tr>";
                            trx += "<td>" + time.getDate() + "/" + time.getMonth() + "/" + time.getFullYear() + " "+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds()+"</td>";
                        	var amountBonus =  (data.data[i].bonus.percent*parseFloat(data.data[i].bonus.amount).toFixed(0))/100;
                            trx += "<td>" + data.data[i].amount.amount + "</td>";
                            trx += "<td>" + data.data[i].rate.btc + "</td>";
                            trx += "<td>" + data.data[i].bonus.amount +"</td>";
                            trx += "<td>"+parseFloat(amountBonus).toFixed(8)+"</td>";
                        	if(!("network" in data.data[i]))
                            {
                            	trx += "<td><label class='label label-info'>Internal Transaction</label></td>";
                            	trx += "<td><label class='label label-info'>Internal Transaction</label></td>";
                            }else{
                            	trx += "<td><a href='https://blockchain.info/tx/" + data.data[i].network.hash + "'  target='_blank' >"+data.data[i].network.hash+"</a></td>";
                            trx += "<td><span class='label label-" + statusLabel + "'>" + data.data[i].status + "</span></td>";
                            }
                            trx += "</tr>";
                            btcTotal = parseFloat(btcTotal) + parseFloat(data.data[i].amount.amount);
                          	var totFras = amountBonus+data.data[i].bonus.amount;
                          	frsTotal = parseFloat(frsTotal) + parseFloat(data.data[i].bonus.amount)+parseFloat(amountBonus);
                            frs = parseFloat(frs)+ parseFloat(data.data[i].bonus.amount);
                            frasBonus =  parseFloat(frasBonus) + parseFloat(amountBonus);
                        }else{
                          continue;
                        }
                    }
                    $("#btctotal").html(parseFloat(btcTotal).toFixed(8));
                    $("#frastotal").html(parseFloat(frsTotal).toFixed(8));
                    $("#frasC").html(parseFloat(frs).toFixed(8));
                    $("#frasBonus").html(parseFloat(frasBonus).toFixed(8));
                    $("#totalFras").html(parseFloat(parseFloat(frsTotal) + parseFloat(frasBonus).toFixed(8)));
                    $("#trx").html(trx);
                });
            }, 500);
        });

    }
    $("#review").click(function() {
      $.get(base_url+"rest/cekReview",function(data) {
          if(data.status != 0)
          {
            alert("You Has Been Reviewed Us");
          }else{

              bootbox.confirm('<div class="row"><div class="col-md-12"><div class="form-group"><textarea class="form-control isi" placeholder="Write Your Review" ></textarea></div></div><div class="col-md-12"><div class="form-group"><input type="text" class="form-control job" placeholder="Your Job (OPTIONAL)" /></div></div><div class="col-md-12"><div class="form-group"><input type="text" class="form-control company" placeholder="Your Company Name (OPTIONAL)" /></div></div></div>', function(result) {
                if(result)
                {
                  var isi = $(".isi").val();
                  var job = $(".job").val();
                  var company = $(".company").val();
                  var dialog = bootbox.dialog({
                      title: 'Please Wait . . .',
                      message: '<center><p><i class="fa fa-spin fa-spinner"></i> Submiting Your Review  . . . .</p></center>'
                  });
                  dialog.init(function(){
                      setTimeout(function(){
                          $.post(base_url+"rest/review",{isi:isi,job:job,company:company}, function(data) {
                            if(data.status == 1)
                            {
                                dialog.find('.bootbox-body').html("<center>"+data.msg+"</center>");
                                dialog.find('.modal-title').html("Request Successfully");
                            }else{
                              dialog.find('.bootbox-body').html("<center>"+data.msg+"</center>");
                              dialog.find('.modal-title').html("Request Rejected");
                            }
                          });
                      }, 1000);
                  });
                }
                });
          }
        });
    });
    var checking = document.getElementById('new_nxt');
    if (checking != null) {
        $(".nothave").click(function() {
            setTimeout(function() {
                $.get(base_url + "/rest/createNXT", function(data) {
                    $("#new_nxt").html("");
                    var html = "";
                    html += '<p style="font-size: 20px; padding-bottom: 12px">Your ARDOR Account Is :</p>';
                    html += ' <div style="overflow:auto; width:100%"><table><tr><td style="font-size: 20px">Account</td><td style="overflow-y: auto;" class="bold addr" style="font-size: 20px">&nbsp&nbsp: <b>' + data.data.nxt_address + '</b></td></tr> <tr><td style="font-size: 20px">Secret </td><td style="overflow-y: auto;" class="bold" style="font-size: 20px">: <b>' + data.data.secretKey + '</b> </td></tr><tr><th></th><td style="color : red;"><p>Save this password in a very secure location or (( <b>PRINT paper wallet</b> )), because you will need this (( <b>ARDOR address</b> ))  and  (( <b>Secret-Passpharse</b> )) after the CROWDSALE, to view how many coins you have in your wallet. Your coin balance will be displayed in the every module.</p></td></tr></table><div></div><center><img  style="padding-bottom:5px;width:500px;height:auto;"  src="data:image/png;base64,'+data.data.card+'"class="img-responsive printIt"></img><br><button onclick="printit()" class="btn btn-info">PRINT Paper Wallet</button></center><p class="hidden token">'+data.data.token+'</p></div>';
                    $("#new_nxt").append(html);
                });
            }, 2000);
        });
        $("#saveNewNXT").click(function() {
            var addr = $(".addr").text();
            var token = $(".token").text();
            addr = addr.replace(":","");
            addr = addr.trim();
            $("#saveNewNXT").attr("disabled", true);
            $.post(base_url + "rest/saveNXT", { nxt_address: addr,token:token }, function(result) {
                setTimeout(function() {
                    if (result.status == 1) {
                        $("#new_nxt").html("");
                        $("#new_nxt").append("<div class='alert alert-success'>New NXT Address Has Been Updated</div>");
                        setTimeout(function() { window.location = base_url+"/shop"; }, 2000);
                    } else {
                        alert(result.msg);
                        setTimeout(function() { window.location = base_url; }, 2000);
                    }
                }, 2000);
            });
            $("#saveNewNXT").attr("disabled", false);
        });
        $("#save_nxt").click(function() {
            var addr = $("#nxt_acc").val();
            var stat;
            $.post(base_url + "rest/validNXT", { address: addr }, function(result) {
                if (result.status == 1) {
                    $.post(base_url + "rest/saveNXT", { nxt_address: addr }, function(result) {
                        if (result.status == 1) {
                            $("#haveit").html("");
                            $("#haveit").append("<div class='alert alert-success'>New NXT Address Has Been Updated</div>");
                            setTimeout(function() { window.location = base_url; }, 2000);
                        } else {
                            alert("Failed to Save new NXT Account");
                            setTimeout(function() { window.location = base_url; }, 2000);
                        }
                    });
                } else {
                    stat = 0;
                    alert("Please Enter Valid NXT Account");
                }
            });
        });
    }
})

function getData() {
    console.log("Update Data . .");
    $.get(base_url + "rest/ticker", function(data) {
        console.log("Get Data");
        var jsonData = data;
        console.log(jsonData);
        $("#dollar_class").removeAttr("class");
        $("#idr_class").removeAttr("class");
        $("#frs_class").removeAttr("class");
        $("#dollar_class").attr("class", jsonData.USD.icon+" fa-2x");
        $("#idr_class").attr("class", jsonData.IDR.icon+" fa-2x");
        $("#frs_class").attr("class", jsonData.FRAS.icon+" fa-2x");
        $("#dollar_value").html(jsonData.USD.value);
        $("#idr_value").html(jsonData.IDR.value);
        $("#frs_value").html(jsonData.FRAS.value);

    });
}
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function getFixed()
{
    $.get(base_url + "rest/getFixed", function(data) {
        console.log("Got Fixed Fras");
        if(data != null)
        {
          $("#remainFras").html(addCommas(parseFloat(data[0].coinsell).toFixed(0)));
        }
    });
}
