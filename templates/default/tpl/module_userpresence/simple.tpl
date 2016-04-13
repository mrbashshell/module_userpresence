<!-- see section "Template-API" of module manual for a list of available placeholders -->

<userpresence_list>
    <div class="userpresenceList">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>


                </tr>
            </thead>
            <tbody id="userpresencelist"></tbody>
        </table>

        <script type="text/javascript">
            KAJONA.portal.loader.loadFile('/templates/default/css/userpresence.css');

            var userpresence = {};

            $(function(){

                //register a default loader of items
                userpresence.loadItems = function(bitNoRegister) {

                    $.getJSON( KAJONA_WEBPATH+"/xml.php?module=userpresence&action=getallusers", function( data ) {

                        var items = [];
                        $.each( data, function( key, val ) {

                            items.push(
                                "<tr id='" + val.systemid + "' data-userid='" + val.systemid + "' data-present='"+val.present+"'>" +
                                "<td class='usertable'>"+val.name+"</td>" +
                                "<td class='usertable'><a onclick='userpresence.changeStatus(this); return false;' href='#' class='status_"+val.present+"'>"+val.presentread+"</a></td>" +
                                "</tr>"
                            );
                        });

                        $('#userpresencelist').html(items.join( "" ));
                    });

                    window.setTimeout(userpresence.loadItems, 3000);
                };
                userpresence.loadItems();

                //on click handler
                userpresence.changeStatus = function(objRow) {
                    var $row = $(objRow).closest('tr');

                    var dataObj = {
                        systemid : $row.data("userid"),
                        present : $row.data("present") == "1" ? "0" : "1"
                    };

                    $.post(KAJONA_WEBPATH+"/xml.php?module=userpresence&action=setstatus", dataObj).success(function(val) {

                        $row.replaceWith(
                            "<tr id='" + val.systemid + "' data-userid='" + val.systemid + "' data-present='"+val.present+"'>" +
                            "<td class='usertable'>"+val.name+"</td>" +
                            "<td class='usertable'><a onclick='userpresence.changeStatus(this); return false;' href='#' class='status_"+val.present+"'>"+val.presentread+"</a></td>" +
                            "</tr>"
                        );
                    });
                };

            });

        </script>

    </div>
</userpresence_list>





