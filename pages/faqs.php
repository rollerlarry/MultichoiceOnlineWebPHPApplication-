<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
?>        
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><img src="images/faqs.png" width="50" height="50"><strong> FAQs <small>Frequently Asked Questions</small></strong></h1>
        	</div>
        </div>
        <div class="row">
            <div id="faq" class="col-md-9">
              <div class="panel-group" id="accordion">

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse-1">
                      What is the purpose of this web application ?
                      </a>
                    </h4>
                  </div>
                  <div id="collapse-1" class="panel-collapse collapse">
                    <div class="panel-body">
                      <p>Online Exam Management</p>
                    </div>
                    <div class="panel-footer">
                      <div class="btn-group btn-group-xs">
                        <span class="btn">Was this question useful?</span>
                        <a class="btn btn-success" href="#" onclick=" alert('Thanks. We are glad that this helps you ')"><i class="fa fa-thumbs-up" ></i> Yes</a> <a class="btn btn-danger" href="#" onclick="alert('Sorry, we will try to improve.')"><i class="fa fa-thumbs-down"></i> No</a></div>
                      <div class="btn-group btn-group-xs pull-right"><a class="btn btn-primary" href="#" onclick="alert('We will review your request.')">Report this question</a></div>
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse-2">
                      How to have account and use the function of this website ?
                      </a>
                    </h4>
                  </div>
                  <div id="collapse-2" class="panel-collapse collapse">
                    <div class="panel-body">
                      <p>Contact with admin of this website and register a new account.</p>
                    </div>
                    <div class="panel-footer">
                      <div class="btn-group btn-group-xs"><span class="btn">Was this question useful?</span><a class="btn btn-success" href="#"><i class="fa fa-thumbs-up"></i> Yes</a> <a class="btn btn-danger" href="#"><i class="fa fa-thumbs-down"></i> No</a></div>
                      <div class="btn-group btn-group-xs pull-right"><a class="btn btn-primary" href="#">Report this question</a></div>
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse-7">
                      When the web application works officially ?
                      </a>
                    </h4>
                  </div>
                  <div id="collapse-7" class="panel-collapse collapse">
                    <div class="panel-body">
                      <p>12-12-2017</p>
                    </div>
                    <div class="panel-footer">
                      <div class="btn-group btn-group-xs"><span class="btn">Was this question useful?</span><a class="btn btn-success" href="#"><i class="fa fa-thumbs-up"></i> Yes</a> <a class="btn btn-danger" href="#"><i class="fa fa-thumbs-down"></i> No</a></div>
                      <div class="btn-group btn-group-xs pull-right"><a class="btn btn-primary" href="#">Report this question</a></div>
                    </div>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse-8">
                      What language is have been used for this website ?
                      </a>
                    </h4>
                  </div>
                  <div id="collapse-8" class="panel-collapse collapse">
                    <div class="panel-body">
                      <p>PHP - MYSQL</p>
                    </div>
                    <div class="panel-footer">
                      <div class="btn-group btn-group-xs"><span class="btn">Was this question useful?</span><a class="btn btn-success" href="#"><i class="fa fa-thumbs-up"></i> Yes</a> <a class="btn btn-danger" href="#"><i class="fa fa-thumbs-down"></i> No</a></div>
                      <div class="btn-group btn-group-xs pull-right"><a class="btn btn-primary" href="#">Report this question</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="faq" class="col-md-3">
              <div class="panel panel-default">
                    <div class="panel-heading">
                        Notes
                    </div>
                    <div class="panel-body">
                       <textarea class="form-control" rows="30" readonly="">Hello</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('include/footer.php') ?>
