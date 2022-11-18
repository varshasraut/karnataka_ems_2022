
<?php
$tab = 14;

$rate = array('1' => 'Lowest', '10' => 'Highest');
?>

<div class="width85">

    <table class="style4">

        <tr>

            <th>Questions<span class="md_field">*</span></th>
            <th>Answers<span class="md_field">*</span></th>

        </tr>

<?php if (is_array($qa_list)) {

    foreach ($qa_list as $qa) {
        ?>

                <tr>

                    <td><?php echo $qa->que_question; ?></td>

                    <?php
                    $ans_data = unserialize($qa->ans_answer);
                    $ans_type = $ans_data['type'];
                    ?>

                    <td>

                        <?php
                        if ($ans_type == 'radio') {

                            $ans = explode(",", $ans_data['values']);


                            $opt = array();
                            $ids = array();

                            foreach ($ans as $an) {

                                $ids[$an] = "fq_" . $qa->que_id . $an;
                                ob_start();
                                ?>

                                <label for="fq_<?php echo $qa->que_id . "" . $an; ?>" class="radio_check width2">


                                    <input type="radio" name="fq[<?php echo $qa->que_id; ?>]" value="<?php echo $an; ?>" id="fq_<?php echo $qa->que_id . "" . $an; ?>" class="filter_either_or[(*:ids:*)] radio_check_input" data-errors="{filter_either_or:'Please select answer.'}" tabindex="<?php echo $tab; ?>">

                                    <span class="radio_check_holder"></span><?php echo $an; ?>


                                </label>



                                <?php
                                $opt[$an] = ob_get_contents();

                                ob_get_clean();
                            }

                            $html = join("", $opt);

                            echo $html = str_replace("(*:ids:*)", join(",", $ids), $html);
                        } else if ($ans_type == 'dropdown') {

                            $ans = explode(",", $ans_data[values]);

                            echo"<div class='input'><select name='fq[" . $qa->que_id . "]' class='filter_required' data-errors=\"{filter_required:'Please select answer.'}\" tabindex='" . $tab . "'>";

                            echo "<option value=''>Rate</option>";

                            foreach ($ans as $an) {

                                echo "<option value='" . $an . "'>" . $an . " " . $rate[$an] . "</option>";
                            }

                            echo"</select></div>";
                        }
                        ?>

                    </td>

                </tr>

                <?php $tab++;
            }
        }
        ?>

    </table>

</div>