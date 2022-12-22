      </div>
      <!-- End Row -->
    </div>
    <!-- End Card Grid -->
    </div>  
  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- ========== FOOTER ========== -->
  <footer class="bg-dark">
    <div class="container pb-1 pb-lg-5">
      <div class="row content-space-t-2">
        <div class="col-lg-3 mb-7 mb-lg-0">
          <!-- Logo -->
          <div class="mb-5">
            <a class="navbar-brand" href="" aria-label="Space">
              <img class="navbar-brand-logo" src="./assets/images/uni.jpg" alt="Image Description">
            </a>
          </div>
          <!-- End Logo -->

          <!-- List -->
          <ul class="list-unstyled list-py-1">
            <li><a class="link-sm link-light" href="#">جامعة بابل - طريق حلة نجف 51002<i class="bi-geo-alt-fill me-1"></i> </a></li>
          </ul>
          <!-- End List -->

        </div>
        <!-- End Col -->


        <div class="col-sm mb-7 mb-sm-0">
          <h5 class="text-white mb-3">الميزات</h5>

          <!-- List -->
          <ul class="list-unstyled list-py-1 mb-0">
            <li><a class="link-sm link-light" href="?page=myWorkshops.php">شهادت المشاركة</a></li>
            <li><a class="link-sm link-light" href="?page=home.php">البحث عن الدورات</a></li>
          </ul>
          <!-- End List -->
        </div>
        <!-- End Col -->

        <div class="col-sm">

          <!-- End List -->
        </div>
        <!-- End Col -->

        <div class="col-sm">

          <!-- End List -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->



      <!-- Copyright -->
      <div class="w-md-85 text-lg-center mx-lg-auto">
        <p class="text-white-50 small">مركز الوسائط المتعددة والتعليم الالكتروني. جميع الحقوق محفوظة  &copy;</p>
      </div>
      <!-- End Copyright -->
    </div>
  </footer>

  <!-- ========== END FOOTER ========== -->

  <!-- ========== SECONDARY CONTENTS ========== -->

  <!-- Go To -->
  <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;"
     data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'>
    <i class="bi-chevron-up"></i>
  </a>
  <!-- ========== END SECONDARY CONTENTS ========== -->

  <!-- JS Global Compulsory  -->
  <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <script src="./assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="./assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>

  <!-- JS Front -->
  <script src="./assets/js/theme.min.js"></script>

  <!-- JS Plugins Init. -->
  <script>
    (function() {
      // INITIALIZATION OF MEGA MENU
      // =======================================================
      new HSMegaMenu('.js-mega-menu', {
          desktop: {
            position: 'left'
          }
        })


      // INITIALIZATION OF BOOTSTRAP DROPDOWN
      // =======================================================
      HSBsDropdown.init()


      // INITIALIZATION OF GO TO
      // =======================================================
      new HSGoTo('.js-go-to')
    })()
  </script>
</body>
</html>
