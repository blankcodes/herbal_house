
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Herbal House</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Membership</a></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Membership</h4> 
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        
                        <?php if ($userData['website_invites_status'] == 'inactive'){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close font-12" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Notice: </strong> Start Earning by Activating your account! Click <a data-bs-toggle="modal" data-bs-target="#payment_modal" href="#click_here" >here</a>.
                            </div>
                        <?php } ?>

                        <div id="payment_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h4 class="modal-title c-white" id="fullWidthModalLabel"><i class="uil-info-circle"></i> <span id="_modal_title">Payment Information</span></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div id="">
                                        <div class="modal-body mb-3">
                                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                                Make sure to pay exact amount of <span class="font-20 fw-600">₱ 2,499</span> and contact us through text/call <a href="tel:09667618942">+63 966 761 8942</a> or email us at <a href="mailto:herbalhouseph@gmail.com">herbalhouseph@gmail.com</a>. <br><br>
                                                Message us your User ID, mobile number, account name and dont forget to include the screenshot or transaction reference number of your payment.
                                            </div>

                                            <div class="mt-2">
                                                Payment Method: <br><span id="_review_pay_method" class="font-25 fw-600"> Gcash</span>
                                            </div>

                                            <div class="mt-2">
                                                Account Number: <br><span id="_review_acct_num" class="font-25 fw-600"> 09955441680</span>
                                            </div>

                                            <div class="mt-2">
                                                Account Name: <br><span id="_review_acct_name" class="font-25 fw-600"> Mark Joseph Susaya</span>
                                            </div>

                                        </div>
                                        <div class="modal-footer mb-2">
                                            <button type="button" class="btn rounded btn-lg rounded font-15 btn-light" data-bs-dismiss="modal" >Close</button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div class="row">
                            <div class="">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="alert alert-success bg-light text-dark border-0" role="alert">
                                                Use your affiliate link to earn more. Get ₱ 1,000 from anyone who register using your affiliate link and activate their account.
                                            </div>
                                            <div class="mt-2">
                                                <div class="form-floating mb-2 mt-2">
                                                     <input type="text" class="form-control" name="username" value="<?=$affData['aff_link'];?>" id="_aff_link" placeholder="Enter username" required autofocus="autofocus" />
                                                    <label for="username" class="fw-400">Affiliate Link</label>
                                                </div>
                                                <div class="mt-2 text-end">
                                                    <button <?=($affData['status'] == 'failed') ? 'disabled="disabled' : ''?> id="copy_url_btn" onclick='copyAffUrl("<?=$affData['aff_link'];?>")' class="btn btn-success btn-md rounded"> <i class="uil-copy"></i> Copy Affiliate Link</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end col-->
                            </div>
                       </div>

                       <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <div class="padding-bottom-50">
                                        <div class=" ">
                                            <div class=" justify-content-center">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                       <div class="alert alert-light fade show c-gray">
                                                            <p class="mt-1">Invite Your Friends or anyone to <span class="text-success">Herbal House Philippines</span> and start Earning from your Direct referrals and Indirect referrals. 
                                                            Also, you can earn from your product purchases and from your Direct and Indirect referrals' purchase.
                                                            </p>
                                                            <p>Share your Affiliate Link to your friends or to Social Media websites and have a chance to get more Invites!</p>
                                                        </div>
                                                    </div>

                                                    <div class="margin-bottom-30 margin-top-30 text-center">
                                                        <h2 class="font-25 mb-2">Start Earning at Home while staying Healthy!</h2>
                                                            <button id="copy_url_btn" <?=($affData['status'] == 'failed') ? 'disabled="disabled' : ''?>  onclick="copyAffUrl('<?=$affData['aff_link'];?>')" class="btn btn-success rounded font-15 k-btn">Invite Your Friends</button>
                                                    </div>
                                                </div>


                                                <div class="row mt-2">
                                                     <div class="col-lg-12 margin-top-50 mb-2">
                                                        <h2 class="badge bg-success font-25 text-left fw-300 abt-img-shadow p-1">Packages</h2>
                                                        <p>These are the packages that you or your invites will get after getting 2,499 Package</p>
                                                    </div>
                                                    <div class="col-lg-4 mt-1">
                                                        <img src="<?=base_url('assets/images/gallery/package-a.webp')?>" class="rounded img-fluid abt-img-shadow" height="420" alt="package A">
                                                    </div>
                                                    <div class="col-lg-4 mt-1">
                                                        <img src="<?=base_url('assets/images/gallery/package-b.webp')?>" class="rounded img-fluid abt-img-shadow" height="420" alt="package b">
                                                    </div>
                                                    <div class="col-lg-4 mt-1">
                                                        <img src="<?=base_url('assets/images/gallery/package-c.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package c">
                                                    </div>
                                                    <div class="col-lg-4 mt-1">
                                                        <img src="<?=base_url('assets/images/gallery/package-d.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package d">
                                                    </div>
                                                    <div class="col-lg-4 mt-1">
                                                        <img src="<?=base_url('assets/images/gallery/package-e.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package e">
                                                    </div>
                                                    <div class="col-lg-4 mt-1">
                                                        <img src="<?=base_url('assets/images/gallery/package-f.webp')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="package f">
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 margin-top-70 mb-2">
                                                    <h2 class="badge bg-success font-25 text-left fw-300 abt-img-shadow p-1">Marketing Materials</h2><br>
                                                    <p>These are the materials you can use to promote with your Affiliate Link on social media or to the website you own. Make sure you always include your Affiliate link when you make post!</p>
                                                </div>
                                                <div class="mt-4 row">
                                                    <div class="col-lg-8">
                                                        <h3 class="mb-3 text-start">Youtube Video</h3>
                                                        <label>Youtube Link</label>
                                                        <input type="text" value="https://youtu.be/QQYOp95Qr84" class="mb-2 form-control">
                                                        <div class="ratio ratio-4x3 ">
                                                            <iframe src="https://www.youtube.com/embed/QQYOp95Qr84?autohide=0&showinfo=0&controls=0" class="br-10 abt-img-shadow"></iframe>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 mt-5">
                                                        <h3 class="mb-2 text-start">Banners</h3>
                                                        <p class="mb-2">You may download and use these banners to promote any <span class="text-success">Herbal House Products</span> with your <span class="fw-600"><a href="<?=base_url('member/products')?>">Product Referral Link <i class="uil-external-link-alt"></i></a></span> so you can earn points when someone buy the products using your link.</p>

                                                        <div class="row">
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/spirulina.jpg')?>">
                                                                     <img src="<?=base_url('assets/images/marketing/spirulina.jpg')?>" class="rounded img-fluid abt-img-shadow" height="420" alt="spirulina">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/serpentina.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/serpentina.jpg')?>" class="rounded img-fluid abt-img-shadow" height="420" alt="serpentina">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/mangosteen.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/mangosteen.jpg')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="mangosteen">
                                                                </a>
                                                                
                                                            </div>
                                                              <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/hebal-house-coffee.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/hebal-house-coffee.jpg')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="hebal house coffee">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/glutagen-coffee.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/glutagen-coffee.jpg')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="glutagen coffee">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/slimming-coffee.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/slimming-coffee.jpg')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="slimming coffee">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/buah-merah.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/buah-merah.jpg')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="buah merah">
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                <a target="_blank" href="<?=base_url('assets/images/marketing/puple-corn-juice.jpg')?>">
                                                                    <img src="<?=base_url('assets/images/marketing/puple-corn-juice.jpg')?>" class="img-fluid rounded abt-img-shadow" height="320" alt="puple corn juice">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                        <!-- end container -->
                                    </div>
                               </div>
                            </div>
                        </div>

                    </div> <!-- container -->
                </div> <!-- content -->
            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>


        <!-- END wrapper -->

