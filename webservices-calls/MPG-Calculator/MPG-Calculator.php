<!--
    MPG Calculator Markup
    Contains the form, mileage values, and error messages
-->
<div id="mpg-calculator">
	<h1 class="mpg-calculator-header">MPG Calculator</h1>
	<p class="mpg-calculator-intro">Calculate miles per gallon and litres per 100 kilometres based on amount of fuel used and distance travelled.</p>

	<!-- calculator table -->
	<table class="mpg-calculator-table">
		<tbody>
			<!-- distance -->
			<tr>
				<th>Distance</th>
				<td>
	                <input type="number" id="distance" name="distance" value="1" placeholder="Distance Travelled" min="1" max="100000000" required />
	            </td>
				<td>
					<select id="distanceunit" name="distanceunit">
						<option selected="" value="m">Miles</option>
						<option value="k">Kilometers</option>
					</select>
				</td>
			</tr>
			<!-- END : distance -->

			<!-- fuel used -->
			<tr>
				<th>Fuel used</th>
				<td>
	                <input type="number" id="fuelused" name="fuelused" value="1" placeholder="Fuel Used" min="1" max="100000000" required />
	            </td>
				<td>
					<select id="fuelunit" name="fuelunit">
						<option selected="" value="l">Litres</option>
						<option value="g">Gallons</option>
					</select>
				</td>
			</tr>
			<!-- END : fuel used -->

			<!-- calculate mpg -->
			<tr>
				<td colspan="2">&nbsp;</td>
				<td><input id="calculateMPG" class="btnPrimary" type="button" value="Calculate"></td>
			</tr>
			<!-- END : calculate mpg -->
		</tbody>
	</table>
	<!-- END : calculator table -->

	<!-- fuel values wrapper -->
	<div id="mpg-calculator-fuel-values">
	    <p class="mpg">Your <strong>MPG</strong> is <strong id="mpgValue">0.0</strong></p>
	    <p class="lpkm">Your <strong>Litres per 100km</strong> is <strong id="lpkmValue">0.0</strong></p>
	</div>
	<!-- END : fuel values wrapper -->

	<!-- errors wrapper -->
	<div id="mpg-calculator-errors">
	    <span><strong>Error:</strong> Please use valid positive numbers</span>
	</div>
	<!-- END : errors wrapper -->

</div>
<!-- END : MPG Calculator Markup -->
