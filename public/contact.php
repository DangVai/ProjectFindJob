<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-DyZ88mC6Up2uqS0OomkhpZpCjYNioIIym1R4czTn3txRzQdD09yJhCZbZiIGu69" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="../cssfile/footer.css">
    <link rel="stylesheet" href="../cssfile/contact.css">
</head>

<body>
    <div class="container"></div>
    <div class="breadcrumb_background margin-bottom-40">
        <div class="title_full">
            <div class="container a-center">
                <p class="title_page">Contact</p>
            </div>
            <section class="bread-crumb">
                <span class="crumb-border"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 a-center">
                            <ul class="breadcrumb">
                                <li class="home">
                                    <a href="../index.php"><span>Home</span></a>
                                    <span class="mr_lr">&nbsp;<i class="fa fa-angle-right"></i>&nbsp;</span>
                                </li>
                                <li><strong><span>Contact</span></strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="infor">
            <ul class="contact padding-3">
                <li class="li_footer_h">
                    <i class="fa-solid fa-house"></i>
                    <span class="add">
                        <a>223 Nguyễn Văn Thoại, Phước Mỹ, Sơn Trà, Da Nang.</a>
                    </span>
                </li>
                <li class="li_footer_h">
                    <i class="fa-solid fa-phone-volume"></i>
                    <a href="#">033321199</a>
                </li>
                <li class="li_footer_h">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:coolteam@gmail.com">handandfoot@gmail.com</a>
                </li>
            </ul>
        </div>
        <div class="tittle">
            <h3>Contact Us</h3>
        </div>
        <form method="post" action="../controllers/contact.php" id="contact" accept-charset="UTF-8">
            <div class="form-signup">
                <div class="group_contact">
                    <fieldset class="form-group">
                        <input placeholder="Full Name" type="text" class="form-control" required="" name="name">
                    </fieldset>
                    <fieldset class="form-group">
                        <input placeholder="Email" type="email" required="" id="email1" class="form-control"
                            name="email">
                    </fieldset>
                    <fieldset class="form-group">
                        <textarea placeholder="Message" name="message" id="comment" class="form-control content-area"
                            rows="5" required=""></textarea>
                    </fieldset>


                    <div class="submit-button">
                        <button type="submit" class="btn-submit">Send Contact</button>
                    </div>
                </div>
            </div>
        </form>

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.1838543986455!2d108.2421226749546!3d16.055946384621596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142177be439fa5d%3A0xf1cf93860eeeb9fc!2zMjIzIE5ndXnhu4VuIFbEg24gVGhv4bqhaSwgUGjGsOG7m2MgTeG7uSwgU8ahbiBUcsOgLCDEkMOgIE7hurVuZyA1NTAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1733370311753!5m2!1svi!2s"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        <?php include '../footer.php'; ?>
    </div>
</body>

</html>