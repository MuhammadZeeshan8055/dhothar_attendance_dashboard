<?php
include("session.php");
$obj = new Database();

// 1) Determine year/month (default to today if none posted)
$month_name = $_POST['month'] ?? date('F');
$month_num  = date('n', strtotime($month_name));
$year       = date('Y');

// 2) Compute how many days to loop
$firstOfMonth  = "$year-$month_num-01";
$totalInMonth  = date('t', strtotime($firstOfMonth));
$isCurrent     = ($year == date('Y') && $month_num == date('n'));
$lastDayToShow = $isCurrent ? date('j') : $totalInMonth;

// 3) Fetch all records for this employee and month, by actual shift_date
$where = "
    emp_id = '{$empid}'
    AND YEAR(shift_date)  = {$year}
    AND MONTH(shift_date) = {$month_num}
";
$obj->select('attendance_record', '*', null, $where);
$rows = $obj->getResult();

// 4) Index rows by normalized date string
$byDate = [];
foreach ($rows as $r) {
    $key = date('Y-m-d', strtotime($r['shift_date']));
    $byDate[$key] = $r;
}

// 5) Prepare your existing totals logic
$hoursPerDay       = $total_working_hours;
$workingDays       = getWorkingDaysInMonth($year, $month_num);
$totalHoursNeeded  = getWorkingHoursInMonth($year, $month_num, $hoursPerDay);
$totalWorked       = calculateEmployeeWorkedHours($empid, $month_name, $obj);

// 6) Start building the table
echo '<table class="table">';
echo '<thead style="position: sticky; top: 0; background: white; z-index: 2;">
        <tr>
          <th class="fs-3 ps-0">Shift Date</th>
          <th class="fs-3">Start Time</th>
          <th class="fs-3">End Time</th>
          <th class="fs-3">Worked Hours</th>
          <th class="fs-3">Overtime</th>
        </tr>
      </thead>
      <tbody>';

$countDays = 0;
$countLeaves = 0;

// 7) Loop through each day
for ($d = 1; $d <= $lastDayToShow; $d++) {
    // normalize to YYYY-MM-DD
    $current = date('Y-m-d', strtotime("$year-$month_num-$d"));
    $weekday = date('w', strtotime($current)); // 0 = Sunday

    // Sunday holiday
    if ($weekday === '0') {
        echo '<tr style="background:#f9f9f9;">
                <td class="ps-0 fs-3">'. formatDate($current) .'</td>
                <td colspan="4" class="fs-3 text-center">Holiday</td>
              </tr>';
        continue;
    }

    // If we have a record for this date
    if (isset($byDate[$current])) {
        extract($byDate[$current]);
        if (! empty($worked_hours)) {
            $countDays++;
        }
        // Check against official hours
        $hrs = (int) explode(' ', $worked_hours)[0];
        $style = $hrs < $official_working_hours ? 'style="color:red;"' : '';
        $cls   = $style ? 'text-danger' : 'text-success';

        echo "<tr {$style}>
                <td {$style} class=\"ps-0 fs-3\">". formatDate($shift_date) ."</td>
                <td {$style} class=\"fs-3\">{$start_time}</td>
                <td {$style} class=\"fs-3\">{$end_time}</td>
                <td {$style} class=\"pe-0\">
                  <span class=\"{$cls} fw-medium fs-3\">{$worked_hours}</span>
                </td>
                <td {$style}>{$overtime}</td>
              </tr>";
    } else {
        // No record: empty row

        $countLeaves++;

        echo "<tr>
                <td class='ps-0 fs-3 text-danger'>". formatDate($current) ."</td>
                <td class='fs-3 text-danger'>--</td>
                <td class='fs-3 text-danger'>--</td>
                <td class='fs-3 text-danger'>--</td>
                <td class='fs-3 text-danger'>--</td>
              </tr>";
    }
}

// 8) Footer with totals (unchanged)
echo "<tr>
        <td>
         Total Leaves ( {$countLeaves} ) Days.
        </td>
        <td colspan=\"2\" class=\"text-end\">
          You have Worked ( {$countDays} ) Days.
        </td>
        <td colspan=\"2\">
          You have Worked <br> ( {$totalWorked} ) <br> Hours, Minutes.
        </td>
      </tr>
      <tr>
        <td colspan=\"3\" class=\"text-end\">
          You need to have at-least
        </td>
        <td colspan=\"2\">
          ( {$totalHoursNeeded} ) <br> Working Hours.
        </td>
      </tr>
      <tr>
        <td colspan=\"2\">
          Official Working Days :
        </td>
        <td>{$workingDays}</td>
        <td colspan=\"2\">
          Official Working Hours <br> : {$totalHoursNeeded} H
        </td>
      </tr>
    </tbody>
  </table>";
?>
