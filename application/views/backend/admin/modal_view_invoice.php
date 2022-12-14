<?php
$edit_data = $this->db->get_where('invoice', array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
?>
<center>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print Invoice
        <i class="entypo-print"></i>
    </a>
</center>

    <br><br>

    <div id="invoice_print">
        <table width="100%" border="0">
            <tr>
                <td align="right">
                    <h5><?php echo ('Date impression'); ?> : <?php echo date('d M,Y', $row['creation_timestamp']);?></h5>
                    <h5><?php echo ('Motif'); ?> : <?php echo $row['title'];?></h5>
                    <h5><?php echo ('Description'); ?> : <?php echo $row['description'];?></h5>
                    <h5><?php echo ('Etat'); ?> : <?php echo $row['status']; ?></h5>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" border="0">    
            <tr>
                <td align="left"><h4><?php echo ('Paiement pour le compte de'); ?> </h4></td>
                <td align="right"><h4><?php echo ('Payement Efféctué Par'); ?> </h4></td>
            </tr>

            <tr>
                <td align="left" valign="top">
                    <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>            
                </td>
                <td align="right" valign="top">
                    <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?><br>
                    <?php 
                        $class_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->class_id;
                        echo ('Class') . ' ' . $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                    ?><br>
                    <?php echo 'ID - ' .  $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->roll; ?><br>
                </td>
            </tr>
        </table>
        <hr>

        <table width="100%" border="0">    
            <tr>
                <td align="right" width="80%"><?php echo ('Montant total'); ?> :</td>
                <td align="right"><?php echo $row['amount']; ?> CDF</td>
            </tr>
            <tr>
                <td align="right" width="80%"><h4><?php echo ('Montant versé'); ?> :</h4></td>
                <td align="right"><h4><?php echo $row['amount_paid']; ?> CDF</h4></td>
            </tr>
            <?php if ($row['due'] != 0):?>
            <tr>
                <td align="right" width="80%"><h4><?php echo ('Reste à Payer'); ?> :</h4></td>
                <td align="right"><h4><?php echo $row['due']; ?> CDF</h4></td>
            </tr>
            <?php endif;?>
        </table>

        <hr>

        <!-- payment history -->
        <h4><?php echo ('Historique des paiements'); ?></h4>
        <table class="table table-bordered table-hover" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr align="center">
                    <th><?php echo ('Date'); ?></th>
                    <th><?php echo ('Amount'); ?></th>
                    <th><?php echo ('Method'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $payment_history = $this->db->get_where('payment', array('invoice_id' => $row['invoice_id']))->result_array();
                foreach ($payment_history as $row2):
                    ?>
                    <tr>
                        <td align="center"><?php echo date("d M, Y", $row2['timestamp']); ?></td>
                        <td align="center"><?php echo $row2['amount']; ?> CDF</td>
                        <td align="center">
                            <?php 
                                if ($row2['method'] == 1)
                                    echo ('Cash');
                                if ($row2['method'] == 2)
                                    echo ('Cheque');
                                if ($row2['method'] == 3)
                                    echo ('Card');
                                if ($row2['method'] == 'paypal')
                                    echo 'Paypal';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tbody>
        </table>
    </div>
<?php endforeach; ?>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Quittance </title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.write('</body></html>');
        mywindow.document.write('</body></html>');
        mywindow.document.write('</body>Signature</html>');
       
        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
<footer>
    <p>
        merci
    </p>
</footer>