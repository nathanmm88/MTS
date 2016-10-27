<!-- leftimage -->
<table width="100%" bgcolor="#d8d8d8" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="left-image">
    <tbody>
        <tr>
            <td>
                <table width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                    <tbody>
                        <tr>
                            <td width="100%">
                                <table bgcolor="#ffffff" width="560" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                    <tbody>
                                        <!-- Spacing -->
                                        <tr>
                                            <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                        </tr>
                                        <!-- Spacing -->
                                        <tr>
                                            <td>
                                                <table width="520" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <!-- Start of left column -->
                                                                <table width="200" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                                                    <tbody>
                                                                        <!-- image -->
                                                                        <tr>
                                                                            <td width="200" height="150" align="center" class="devicewidth">
                                                                                <img src="img/leftimg.jpg" alt="" border="0" width="200" height="150" style="display:block; border:none; outline:none; text-decoration:none;" class="col2img">
                                                                            </td>
                                                                        </tr>
                                                                        <!-- /image -->
                                                                    </tbody>
                                                                </table>
                                                                <!-- end of left column -->
                                                                <!-- spacing for mobile devices-->
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="mobilespacing">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!-- end of for mobile devices-->
                                                                <!-- start of right column -->
                                                                <table width="300" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidthmob">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #2d2a26; text-align:left; line-height: 24px;" class="padding-top-right15">
                                                                                Thanks for your order <?php echo $order->getFirstName(); ?>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- end of title -->
                                                                        <!-- Spacing -->
                                                                        <tr>
                                                                            <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                                        </tr>
                                                                        <!-- /Spacing -->
                                                                        <!-- content -->
                                                                        <tr>
                                                                            <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #7a6e67; text-align:left; line-height: 24px;" class="padding-right15">
                                                                                Your order has been received and will be with you at
                                                                            </td>

                                                                        </tr>
                                                                        <?php
                                                                        foreach ($order->getItems() as $orderItem) {

                                                                            $item = $menu->getItem($orderItem->getItemId(), $orderItem->getVariationId());
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $item->getName(); ?></td>
                                                                                <td><?php echo $item->getPrice(); ?></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <!-- end of content -->
                                                                    </tbody>
                                                                </table>
                                                                <!-- end of right column -->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!-- Spacing -->
                                        <tr>
                                            <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                        </tr>
                                        <!-- Spacing -->
                                        <!-- Spacing -->
                                        <tr>
                                            <td height="5" bgcolor="#2d2a26" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                        </tr>
                                        <!-- Spacing -->
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<!-- end of left image -->


