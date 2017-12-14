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

      //////////////////
      // String
      //////////////////

      var visible_genes = cgm.params.network_data.row_nodes_names;

      var low_opacity = 0.7;
      var high_opacity = 1.0;
      var icon_size = 42;
      var d3_tip_custom = cgm.d3_tip_custom();

      var enrichr_description = 'STRING network';
      // d3-tooltip
      var enr_tip = d3_tip_custom()
        .attr('class', function(){
          var root_tip_selector = cgm.params.viz.root_tips.replace('.','');
          var class_string = root_tip_selector + '_string_tip d3-tip';
          return class_string;
        })
        .direction('se')
        .offset([-10,-5])
        .html(function(d){
          return enrichr_description;
        });

      var enr_logo = d3.select(cgm.params.root+' .viz_svg').append("svg:image")
      .attr('x', 100)
      .attr('y', 2)
      .attr('width', icon_size)
      .attr('height', icon_size)
      .attr("xlink:href", "https://string-db.org/images/string_logo_2015_left.png")
      .style('opacity', low_opacity)
      .classed('string_logo', true)
      .attr('id', 'a')
      .on('click', function(){
        $(cgm.params.root+' .string_info').modal('toggle');

        d3.tsv('fetch.php?type=ppi&genes='+visible_genes.join(','), function(err, data) {

          data.pop();

          d3.select(cgm.params.root+' .string_info h4')
            .html('Please resolve the identifiers');
          
          // d3.select(cgm.params.root+' .string_info p.gene_text')
          //   .text(JSON.stringify(data));

          $(cgm.params.root+' .string_info .gene_text').html('');

          d3.select(cgm.params.root+' .string_info .gene_text')
            .selectAll('label')
            .data(data)
            .enter()
            .append("label")
            .html(function(d, i){
              var html = '';
              if(data[i-1] !== undefined) {

              var previous = data[i-1][Object.keys(data[i-1])[0]];
              var current = data[i][Object.keys(data[i])[0]];

                if(previous != current) {
                  data[i].new = previous != current;
                  html += '<h5>'+current+'</h5><hr>';
                }
              } else {
                html += '<h5>'+visible_genes[i]+'</h5><hr>';
                data[i].new = previous != current;
              }
              return html+d.preferredName+' ';
            })
            .append('input')
            .attr('type','radio')
            .attr('checked', function(d, i){
              if(d.new)
                return 'checked';
              else
                return 'false';
            })
            .attr('name', function(d){
              return visible_genes[d[Object.keys(d)[0]]];
            })
            .attr('value', function(d){
              return d.stringId;
            })
            .html(function(d){
              return d.preferredName;
            });

            d3.select(cgm.params.root+' .string_info .gene_text').append('hr');

            d3.select(cgm.params.root+' .string_info .gene_text')
              .append('button')
              .attr('type','button')
              .classed('btn',true)
              .classed('btn-primary',true)
              .html("Retrieve network")
              .on('click', function(){

                var arr = [];
                $('.string_info input[type="radio"]:checked').each(function(){
                  arr.push($(this).val());
                });

                var img_url = 'http://string-db.org/api/image/networkList?identifiers='+arr.join('%0D')+'&required_score=400&network_flavor=confidence';

                //http://string-db.org/api/image/network?identifiers=4932.YML115C%0D4932.YJR075W&required_score=400&network_flavor=confidence
                $('.string_info .gene_text').html('<a href="'+img_url+'" target="_blank"><img src="'+img_url+'"></img></a>');

              });

        });
      })
      .on('mouseover', function(){
          // show tooltip
          d3.selectAll(cgm.params.viz.root_tips + '_string_tip')
            .style('opacity', 1)
            .style('display', 'block');

          enr_tip.show();
      })
      .on('mouseout', function(){
        // hide tooltip
        d3.selectAll( cgm.params.viz.root_tips + '_string_tip')
          .style('opacity', 0)
          .style('display', 'block');

        enr_tip.hide();
      })
      .call(enr_tip);

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
