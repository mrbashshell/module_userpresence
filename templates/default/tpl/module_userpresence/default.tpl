<!-- see section "Template-API" of module manual for a list of available placeholders -->

<userpresence_list>
    <div class="userpresenceList">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Anrufe</th>
                    <th>Bemerkung</th>
                    <th>Letzte Änderung</th>
                </tr>
            </thead>
            <tbody id="userpresencelist"></tbody>
        </table>

        <script type="text/javascript">
            KAJONA.portal.loader.loadFile('/templates/default/css/userpresence.css');

            var userpresence = {};

            $(function(){

                userpresence.renderEntry = function( val, row ) {

                    var objEntry =
                        "<tr id='" + val.systemid + "' data-userid='" + val.systemid + "' data-present='"+val.present+"' data-nocalls='"+val.nocalls +"' >" +
                        "<td class='usertable'>"+val.name+" ("+val.shortname+")</td>" +
                        "<td class='usertable'><a onclick='userpresence.changeStatus(this); return false;' href='#' class='statusbutton status_"+val.present+"'>"+val.presentread+"</a></td>" +
                        "<td class='usertable'><a onclick='userpresence.changeCallstatus(this); return false;' href='#' class='statusbutton callstatus_"+val.nocalls+"'>"+val.nocallsread;

                    if(val.nocalls==0) {
                        objEntry = objEntry + " <span class='fa-stack smallicon'> <i class='fa fa-phone fa-stack-1x'></i><i class='fa fa-ban fa-stack-2x'></i></span></a></td>";
                    }
                    else {
                        objEntry = objEntry + " <i class='fa fa-phone fa-lg'></i></a></td>";
                    }



                    objEntry = objEntry +
                        "<td class='usertable'><a href='?admin=1&module=userpresence&action=edit&systemid="+val.systemid+"' class='commentlink'>"+val.comment+"<i class='fa fa-pencil'></i></a></td>" +
                        "<td class='usertable'>"+val.lastchange+"</td>" +
                        "</tr>";

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

                    window.setTimeout(userpresence.loadItems, 3000);
                };
                userpresence.loadItems();




                //on click handler 1
                userpresence.changeStatus = function(objRow) {
                    var $row = $(objRow).closest('tr');

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
                    var $row = $(objRow).closest('tr');

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





