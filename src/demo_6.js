$(document).ready(function() {
    $('#tabTypeA').DataTable( {
        "ajax": 'getCalcFailNode.php?type=TypeA',
		"order": [[ 1, "desc" ]]
    } );
    $('#tabTypeB').DataTable( {
        "ajax": 'getCalcFailNode.php?type=TypeB',
		"order": [[ 1, "desc" ]]
    } );
    $('#tabTypeC').DataTable( {
        "ajax": 'getCalcFailNode.php?type=TypeC',
		"order": [[ 1, "desc" ]]
    } );
			
} );