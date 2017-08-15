/*
var defaults = {
    // Label options
    row_label_scale: 1,
    col_label_scale: 1,
    super_labels: false,
    super: {},
    show_label_tooltips: true,
    show_tile_tooltips: true,
    // matrix options
    transpose: false,
    tile_colors: ['#FF0000', '#1C86EE'],
    bar_colors: ['#FF0000', '#1C86EE'],
    // value-cat colors
    // cat_value_colors: ['#2F4F4F', '#8A2BE2'],
    cat_value_colors: ['#2F4F4F', '#9370DB'],
    outline_colors: ['orange','black'],
    highlight_color: '#FFFF00',
    tile_title: false,
    // Default domain is set to 0: the domain will be set automatically
    input_domain: 0,
    opacity_scale: 'linear',
    do_zoom: true,
    is_zoom:0,
    background_color: '#FFFFFF',
    super_border_color: '#F5F5F5',
    outer_margins: {
      top: 0,
      bottom: 0,
      left: 0,
      right: 0
    },
    ini_expand: false,
    grey_border_width: 2,
    tile_click_hlight: false,
    super_label_scale: 1,
    make_tile_tooltip: function(d) { return d.info; },
    // initialize view, e.g. initialize with row filtering
    ini_view: null,
    use_sidebar: true,
    title:null,
    about:null,
    sidebar_width:160,
    sidebar_icons:true,
    row_search_placeholder:'Row',
    buffer_width:10,
    show_sim_mat:false,
    cat_colors:null,
    resize:true,
    clamp_opacity:0.85,
    expand_button:true,
    max_allow_fs: 20,
    dendro_filter:{'row':false, 'col':false},
    cat_filter:{'row':false, 'col':false},
    row_tip_callback:null,
    col_tip_callback:null,
    tile_tip_callback:null,
    new_cat_data:null
  };
*/
var hzome = ini_hzome();
var about_string = 'Zoom, scroll, and click buttons to interact with the clustergram. <a href="http://amp.pharm.mssm.edu/clustergrammer/help"> <i class="fa fa-question-circle" aria-hidden="true"></i> </a>';

function make_clust(entry){

  var querystr = '';

  if(entry === undefined)
    querystr = 'fetch.php?type=table&gene='
    +$('#gene').val()
    +'&tissue='+$('#tissue').val()
    +'&cutoff='+$('#cutoff').val()
    +'&project='+$('#project').val()
    +'&female='+$('#female-switch').prop('checked')
    +'&male='+$('#male-switch').prop('checked');
  else
    querystr = 'default.json';

    // d3.json('json/'+inst_network, function(network_data){
    d3.json(querystr, function(network_data){

      if(network_data){
      $('#container-id-1').html('');
      // define arguments object
      var args = {
        root: '#container-id-1',
        'network_data': network_data,
        'about':about_string,
        // 'row_tip_callback':hzome.gene_info,
        'col_tip_callback':test_col_callback,
        'tile_tip_callback':test_tile_callback,
        'dendro_callback':dendro_callback,
        'matrix_update_callback':matrix_update_callback,
        'sidebar_width':150,
        'super_labels': false
        // 'ini_view':{'N_row_var':20}
      };

      resize_container(args);

      d3.select(window).on('resize',function(){
        resize_container(args);
        cgm.resize_viz();
      });

      cgm = Clustergrammer(args);

      check_setup_enrichr(cgm);

      d3.select(cgm.params.root + ' .wait_message').remove();

    } else {
      alert("No results matched your query.");
    }

  });

}


function matrix_update_callback(){

  if (genes_were_found[this.root]){
    enr_obj[this.root].clear_enrichr_results(false);
  }
}

function test_tile_callback(tile_data){
  var row_name = tile_data.row_name;
  var col_name = tile_data.col_name;

  var highlight = tile_data.col_name.split("/");

  d3.select('#sex_'+highlight[1])
    .style('display','block');

  $("[id^='main_']").hide();
  $('#tissue_'+highlight[0].replace(' ','_')).closest("[id^='main_']").show();

  d3.select('#tissue_'+highlight[0].replace(' ','_'))
    .classed('highlight',true);

  d3.select('#tissue-label')
    .text(highlight[0]);
}

function test_col_callback(col_data){
  var col_name = col_data.name;
}

function dendro_callback(inst_selection){

  var inst_rc;
  var inst_data = inst_selection.__data__;

  // toggle enrichr export section
  if (inst_data.inst_rc === 'row'){
    d3.select('.enrichr_export_section')
      .style('display', 'block');
  } else {
    d3.select('.enrichr_export_section')
      .style('display', 'none');
  }

}

function resize_container(args){

  // var screen_width = window.innerWidth;
  // var screen_height = window.innerHeight - 20;

  var screen_width = document.getElementById('clustergrammer').offsetWidth;
  var screen_height = window.innerHeight - 96;

  d3.select(args.root)
    .style('width', screen_width+'px')
    .style('height', screen_height+'px');
}
