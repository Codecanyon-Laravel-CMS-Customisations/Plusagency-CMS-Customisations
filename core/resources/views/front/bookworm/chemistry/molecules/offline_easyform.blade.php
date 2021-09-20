<!-- Easy Forms -->
<link href="https://forms.upwork-plus.test/static_files/css/form.popup.min.css" rel="stylesheet" type="text/css">
<style>
    .ef-modal {
        background: rgba(0, 0, 0, 0.75) !important; /* Overlay color */
    }
    .ef-modal-box {
        margin: 60px auto !important; /* Pop-Up margin */
        padding: 20px !important; /* Pop-Up pading */
        width: 60% !important; /* Pop-Up width */
        border-radius: 10px !important; /* Pop-Up radius */
        background: rgb(255, 255, 255) !important; /* Pop-Up background */

        /** Animation duration **/
        -webkit-transition: all 0.6s !important;
        -moz-transition: all 0.6s !important;
        -o-transition: all 0.6s !important;
        transition: all 0.6s !important;
    }
</style>
<div class="ef-btn-wrapper ef-btn-wrapper-1">
    <button id="ef-button-1" class="ef-button ef-button-1 ef-button-default ef-button-inline-placement">Open Pop-Up Form</button>
</div>
<div id="ef-content-1" class="ef-content-wrapper">
    <div id="c1" class="ef-content">
        Fill out my <a href="https://forms.upwork-plus.test/app/form?id=2lyEsw">online form</a>.
    </div>
    <script type="text/javascript">
        (function(d, t) {
            var s = d.createElement(t), options = {
                'id': '2lyEsw',
                'container': 'c1',
                'height': '644px',
                'form': '//forms.upwork-plus.test/app/embed'
            };
            s.type= 'text/javascript';
            s.src = '//forms.upwork-plus.test/static_files/js/form.widget.js';
            s.onload = s.onreadystatechange = function() {
                var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
                try { (new EasyForms()).initialize(options).display() } catch (e) { }
            };
            var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
        })(document, 'script');
    </script>
</div>
<script src="//forms.upwork-plus.test/static_files/js/form.popup.min.js"></script>
<script type="text/javascript">
    var modal1 = new EasyForms.Modal({
        autoOpen: false,
        cssClass: ['ef-effect-fade-in']
    });
    var btn1 = document.querySelector('.ef-button-1');
    btn1.addEventListener('click', function(){
        modal1.open();
    });
    modal1.setContent(document.getElementById('ef-content-1'));
</script>
<!-- End Easy Forms -->
