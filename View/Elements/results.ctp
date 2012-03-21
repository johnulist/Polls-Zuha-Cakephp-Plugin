<?php
// this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
// it allows a database driven way of configuring elements, and having multiple instances of that configuration.
if(!empty($instance) && defined('__POLLS_RESULTS_'.$instance)) {
	extract(unserialize(constant('__POLLS_RESULTS_'.$instance)));
} else if (defined('__POLLS_RESULTS')) {
	extract(unserialize(__POLLS_RESULTS));
}
extract($this->requestAction("/polls/poll_votes/results/{$model}/{$foreignKey}")); ?>
    
<div class="pollVotes results">
	<div id="pie_div"></div>
	<div id="bar_div"></div>
    <div id="voters">
	<?php
	foreach ($poll['PollOption'] as $option) { ?>
    	<div class="option">
			<?php echo $option['option']; ?>
            <ul>
            	<?php 
				foreach ($option['PollVote'] as $vote) { ?>
            	<li><?php echo $this->Html->link($vote['User']['full_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $vote['User']['id'])); ?></li>
                <?php
				} ?>
            </ul>
        </div>
	<?php
	} ?>
    </div>
</div>


 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Answers');
        data.addRows([
		<?php
		foreach ($poll['PollOption'] as $option) { ?>
          ['<?php echo $option['option']; ?>', <?php echo $option['vote_count']; ?>],
		<?php
		} ?>
        ]);

        // Set chart options
        var options = {'title':'<?php echo $poll['Poll']['question']; ?>',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('pie_div'));
        var bar = new google.visualization.BarChart(document.getElementById('bar_div'));
        chart.draw(data, options);
        bar.draw(data, options);
      }
    </script>
