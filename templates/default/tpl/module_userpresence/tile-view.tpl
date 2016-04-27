<!-- see section "Template-API" of module manual for a list of available placeholders -->

<userpresence_list>
    <div class="userpresenceList">





            <div id="userpresencelist"></div>



        <script type="text/javascript">
            KAJONA.portal.loader.loadFile('/templates/default/css/userpresence.css');

            var userpresence = {};

            $(function(){

                userpresence.renderEntry = function( val, row ) {

                    var objEntry =
                        "<div class='divwrapper' id='" + val.systemid + "' data-userid='" + val.systemid + "' data-present='"+val.present+"' data-nocalls='"+val.nocalls +"' >" +
                        "<div>   <a onclick='userpresence.changeStatus(this); return false;' href='#' class='statustile status_"+val.present+"'>"+val.shortname+"<br />";

                    if(val.present==1) {
                        objEntry = objEntry + "<i class='fa fa-home'></i>";
                    }
                    else {
                        objEntry = objEntry + "<i class='fa fa-car'></i>";
                    }


                    objEntry = objEntry +
                        "</a></div>" +
                        "</div>";

                    if(row) {
                        row.replaceWith(objEntry);
                    }
                    else {
                        return objEntry;
                    }

                };


                //register a default loader of items - das hier erzeugt beim ersten Aufruf die Liste und alle 3000 ms
                userpresence.loadItems = function(bitNoRegister) {

                    $.getJSON( KAJONA_WEBPATH+"/xml.php?module=userpresence&action=getallusers", function( data ) {

                        var items = [];
                        $.each( data, function( key, val ) {
                            items.push(userpresence.renderEntry(val));
                        });

                        $('#userpresencelist').html(items.join( "" ));
                    });

                    window.setTimeout(userpresence.loadItems, 5000);
                };
                userpresence.loadItems();




                //on click handler 1
                userpresence.changeStatus = function(objRow) {
                    var $row = $(objRow).closest('div.divwrapper');

                    var dataObj = {
                        systemid : $row.data("userid"),
                        present : $row.data("present") == "1" ? "0" : "1"
                    };

                    $.post(KAJONA_WEBPATH+"/xml.php?module=userpresence&action=setstatus", dataObj).success(function(val) {
                        userpresence.renderEntry(val, $row);
                    });
                };

                //on click handler 2
                userpresence.changeCallstatus = function(objRow) {
                    var $row = $(objRow).closest('div.divwrapper');

                    var dataObj = {
                        systemid : $row.data("userid"),
                        nocalls : $row.data("nocalls") == "1" ? "0" : "1"
                    };

                    $.post(KAJONA_WEBPATH+"/xml.php?module=userpresence&action=setcallstatus", dataObj).success(function(val) {
                        userpresence.renderEntry(val, $row);
                    });
                };


            });

        </script>

    </div>
</userpresence_list>





