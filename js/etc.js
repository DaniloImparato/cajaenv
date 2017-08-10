/*
$(selector).tagsInput({
   'autocomplete_url': url_to_autocomplete_api,
   'autocomplete': { option: value, option: value},
   'height':'100px',
   'width':'300px',
   'interactive':true,
   'defaultText':'add a tag',
   'onAddTag':callback_function,
   'onRemoveTag':callback_function,
   'onChange' : callback_function,
   'delimiter': [',',';'],   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : true,
   'minChars' : 0,
   'maxChars' : 0, // if not provided there is no limit
   'placeholderColor' : '#666666'
});

$('#gene').tagsInput({
    autocomplete_url:'fetch.php?type=gene',
});
$('#tissue').tagsInput({
    autocomplete_url:'fetch.php?type=tissue'
});
*/

$( function() {
    make_clust(true);

    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }

    function autocomplete(type){
        return {
            source: function( request, response ) {
                $.getJSON( "fetch.php?type="+type+(type=="tissue" ? "&project="+$('#project').val() : ""), {
                term: extractLast( request.term )
                }, response );
            },
            search: function() {
                // custom minLength
                var term = extractLast( this.value );
                if ( term.length < 2 ) {
                return false;
                }
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                return false;
            }
        }
    }

    $("#gene, #tissue").each(function(i,el){
        // don't navigate away from the field on tab when selecting an item
        $(el).on( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete(autocomplete(this.id));
    });

    d3.json('fetch.php?type=project', function(data){
        // $("#project option").remove();
        // $("#project").append('<option value="" disabled selected></option>')
        $.each(data, function(){
            $("#project").append('<option value="'+ this +'">'+ this +'</option>')
        })
    });

    $('#form-reset').click(function(){
        $('#gene').val('');
        $('#tissue').val('');
        $('#cutoff').val('5000');
    })

    $('#make-clust').click(function(){
        // if($('#project').val()){
        //     make_clust();
        // } else {
        //     alert('Select project');
        // }
        make_clust();
    })
    
});