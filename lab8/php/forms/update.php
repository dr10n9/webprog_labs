<!DOCTYPE html>
<html>
<head>
    <script src="../../js/jquery-3.7.1.min.js" type="text/javascript"></script>
</head>
<body>

<?php
    require_once '../../db.php';

    $id = $_GET['id'] ?? null;
    $start = $_GET['start'] ?? null;
    $end = $_GET['end'] ?? null;
    
    $reservation;
    if ($id) {
        $stmt = $db->prepare("SELECT status, paid FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $reservation = [
            'status' => 'New',
            'paid' => 0
        ];
    }
    
?>

<form id="f1" action="../updateReservation.php">
    <div>Status:</div>
    <div>
        <select id="status" name="status">
            <?php 
                $options = array("New", "Confirmed", "Arrived", "CheckedOut");
                foreach ($options as $option) {                   
                    $selected = $option == $reservation['status'] ? ' selected="selected"' : '';
                    print "<option value='$option' $selected>$option</option>";
                }
            ?>
        </select>
    </div>

    <div>Paid:</div>
    <div>
        <select id="paid" name="paid">
            <?php 
                $options = array(0, 50, 100);
                foreach ($options as $option) {
                    $selected = $option == $reservation['paid'] ? ' selected="selected"' : '';
                    $label = $option . "%";
                    print "<option value='$option' $selected>$label</option>";
                }
            ?>
        </select>
    </div>

    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
    <input type="hidden" name="start" value="<?php echo htmlspecialchars($start); ?>" />
    <input type="hidden" name="end" value="<?php echo htmlspecialchars($end); ?>" />

    <div class="space">
        <input type="submit" value="Save"/>
        <a href="javascript:close();">Cancel</a>
    </div>
</form>

</body>

<script>
    function close(result) {
        if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
            parent.DayPilot.ModalStatic.close(result);
        }
    }

    $("#f1").submit(function () {
        var f = $("#f1");
        console.log(f.attr("action"), f.serialize()); // will include id
        $.post(f.attr("action"), f.serialize(), function (result) {
            close(result);
        });
        return false;
    });
</script>
</html>