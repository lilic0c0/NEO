$(document).ready(function() {
    $('#tabTypeA').DataTable( {
        "ajax": 'getCalcFailCircuit.php?type=TypeA',
		"order": [[ 1, "desc" ]]
    } );
    $('#tabTypeB').DataTable( {
        "ajax": 'getCalcFailCircuit.php?type=TypeB',
		"order": [[ 1, "desc" ]]
    } );
    $('#tabTypeC').DataTable( {
        "ajax": 'getCalcFailCircuit.php?type=TypeC',
		"order": [[ 1, "desc" ]]
    } );
			
} );