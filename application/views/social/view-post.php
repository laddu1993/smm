<link rel="stylesheet" href="<?= site_url('cms-assets/css/item.css') ?>">
<section class="FiHD-setting">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 padding-bottom-10">

                <div class="panels dashboard marginbtm0">

                    <h4 class="dashboard-heading fontcolor-primary text-bold">Social Post <a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAA0lBMVEUAAAAAgP8Aff8Ae/8Aff8Ae/8AfP8Aev0AfP8Ae/8AefoAX8QAX8QAYMUAYMUAYMYAYcYAYMQAYMYAW70AXL0AXL4AePUAePYAd/UAe/0Ae/4Aev0AW7wAXL0AXb4AXcAAevwAY8sAY8sAZM0AZc4AbeAAbeEAbeIAbuMAb+QAe/wAe/0AfP4AfP8Bff8IgP8QhP8Thv8jjv8pkf8vlP80l/82mP89m/9Bnf9Qpf9erP9frf90uP9+vf+UyP+x1/+22f+52//U6f/a7P/c7f/j8f/bq60bAAAAJXRSTlMAIDc4OzySlLe41Nvc3N3d3d7e4+Pj6Ojp6enq6+zt7e76/Pz8DToV1QAAANpJREFUKM+1UlcbgjAMBNkVcaMCAopb6xb3Qv3/f0nbUgSeNS+X765J2ksZ5vchSMB1gcSnaFbRVcfzHLWusHGeM4tDiGOgmVzsvFmFNCZV81ujFBG1vd/8D4xLcjRXR31mj93hNf0kfZ3eQFJRweoK4XOOspwYCsAJ+68DDDYIBbdD+EXgY/RcKnhEOJ0JtqkAbEIcNwSbIDEcwuWCoEqHC/UeJi57DN1aZJiijaOXw1FBjllSiZRR2YjZyDW0PuF7eSOTsF3Ws1arZWVrMpvaCC+iRYn8H/7AG+OYJgadRoX7AAAAAElFTkSuQmCC" data-toggle="tooltip" title="Knowledge Base" class="float-right img-height marginleft" alt="" pagespeed_url_hash="3175268275" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></h4>

                    <div class="row ">
                        <div class="col-xs-12">
                            <div class="setting-section">
                                <span class="fontcolor-primary  margin-sides cursor textbold" id="tab1" style="margin-left:40px;"><a href="<?= site_url('SocialPost/social_board') ?>" style="color: #2d3e50">Create Post </a></span>

                                <span class="fontcolor-primary text-active margin-sides cursor textbold" id="tab2"><a href="<?= site_url('SocialPost/view_post') ?>" style="color: #2d3e50"> View Post </a></span>
                            </div>

                        </div>
                    </div>


                </div>

            </div>
        </div>
        <div class="text-center">
            <div class="">
                <div class="">
                    <div class="masonry">
                        <?php if (!empty($view_post)) { foreach ($view_post as $value) { ?>
                        <div class="item">
                            <?php if(!empty($value['description'])){ ?>
                            <p class="content1">
                                <?php echo $value['description']; ?>
                            </p>
                            <?php } if(!empty($value['image_name'])){ ?>
                            <img src="<?php echo $value['image_name']; ?>" />
                            <?php } ?>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= site_url('cms-assets/vendor/jquery/dist/jquery.js') ?>"></script>
