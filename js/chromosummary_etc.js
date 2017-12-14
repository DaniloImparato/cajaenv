d3.tsv("chromosummary/calli_chromosomes.tsv",function(err,chromosomesData){
    if (err) throw error;
    chromosomesData.map(function(x){
        x.size = parseInt(x.size);
        x.phenotype = [];
    });
    getPhenotype(chromosomesData);
});

function getPhenotype(chromosomesData){
    d3.tsv("chromosummary/calli_phenotype.tsv",function(err,phenotypeData){

        var labels = [];

        phenotypeData.map(function(phenotype){
            phenotype.position = parseInt(phenotype.position);
            chromosomesData.filter(function(chromosome){
                return chromosome.chrname==phenotype.chrname;
            })[0].phenotype.push(phenotype);

            labels.push(phenotype.label);
        })

        labels = labels.filter(function(value, index, self) { 
            return self.indexOf(value) === index;
        });

        chromosummary({chromosomesData: chromosomesData, labels: labels}, colorCallback);
        
    });
}

function colorCallback(labelColor){
    console.log(labelColor);
    d3.select("#phenotype").selectAll("option")
                        .data(d3.entries(labelColor))
                        .enter()
                        .append("option")
                        .attr("value", function (d) { return d.value.id; })
                        .text(function (d) { return d.key; });
}

$('#form-reset').click(function(){
    d3.selectAll("g.annot").attr('visibility','visible');
})

$('#filter-phenotype').click(function(){
    var phenotype = $('#phenotype').val();
    d3.selectAll("g.annot").attr('visibility','visible');
    d3.selectAll("g.annot:not([data-phenotype='"+phenotype+"'])").attr('visibility','hidden');
})