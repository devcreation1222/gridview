angular
    .module('myApp', ['ngMaterial', 'ui.router', 'angular-flexslider'])
    .controller('AppCtrl', function($scope, $timeout, $mdSidenav, $log, $http) {
        $scope.toggleLeft = buildDelayedToggler('left');
        $scope.filterLeft = buildToggler('filter-left');
        $scope.isOpen = false;
        $scope.isColOpen = false;

        function debounce(func, wait, context) {
            var timer;

            return function debounced() {
                var context = $scope,
                    args = Array.prototype.slice.call(arguments);
                $timeout.cancel(timer);
                timer = $timeout(function() {
                    timer = undefined;
                    func.apply(context, args);
                }, wait || 10);
            };
        }

        function buildDelayedToggler(navID) {
            return debounce(function() {
                // Component lookup should always be available since we are not using `ng-if`
                $mdSidenav(navID)
                    .toggle()
                    .then(function() {
                        $log.debug("toggle " + navID + " is done");
                    });
            }, 200);
        }

        function buildToggler(componentId) {
            return function() {
                $mdSidenav(componentId).toggle();
            };
        }

        $scope.toggle = function() {
            $scope.isOpen = !$scope.isOpen;
            console.log($scope.isOpen);
        }

        $scope.colToggle = function() {
            $scope.isColOpen = !$scope.isColOpen;
        }

        $scope.close = function() {
            $mdSidenav('left').close();
        }

        $scope.filter_option = [];

        $scope.selectAllCurCate = function(id) {
            var parent_sate = 0;
            var filter_state = 0;
            for (let index = 0; index < $scope.filter_option.length; index++) {
                if ($scope.filter_option[index].id == id) {
                    if ($scope.filter_option[index].state == 1) {
                        $scope.filter_option[index].state = 0;
                    } else {
                        $scope.filter_option[index].state = 1;
                    }
                    parent_sate = $scope.filter_option[index].state;
                    for (let idx = 0; idx < $scope.filter_option.length; idx++) {
                        if ($scope.filter_option[idx].parent == id) {
                            $scope.filter_option[idx].state = parent_sate;
                        }
                    }
                }
                filter_state += $scope.filter_option[index].state;
            }
            if (filter_state) {
                $scope.filterItems();
            } else {
                $scope.clearFilter();
            }
        }

        $scope.selectCurItem = function(id) {
            var parent_id = 0;
            var parent_state = 1;
            for (let index = 0; index < $scope.filter_option.length; index++) {
                if ($scope.filter_option[index].id == id) {
                    if ($scope.filter_option[index].state == 1) {
                        $scope.filter_option[index].state = 0;
                    } else {
                        $scope.filter_option[index].state = 1;
                    }
                    parent_state = parent_state * $scope.filter_option[index].state;
                    parent_id = $scope.filter_option[index].parent;
                    for (let idx = 0; idx < $scope.filter_option.length; idx++) {
                        if ($scope.filter_option[idx].parent == parent_id) {
                            parent_state = parent_state * $scope.filter_option[idx].state;
                        }
                    }
                }
            }
            var filter_state = 0;
            for (let index = 0; index < $scope.filter_option.length; index++) {
                if ($scope.filter_option[index].id == parent_id) {
                    $scope.filter_option[index].state = parent_state;
                }
                filter_state += $scope.filter_option[index].state;
            }
            if (filter_state) {
                $scope.filterItems();
            } else {
                $scope.clearFilter();
            }
        }

        $scope.checkedItem = function(id) {
            for (let index = 0; index < $scope.filter_option.length; index++) {
                if ($scope.filter_option[index].id == id && $scope.filter_option[index].state == 1) {
                    return true;
                }
            }
            return false;
        }

        $scope.clearFilter = function() {
            for (let index = 0; index < $scope.filter_option.length; index++) {
                $scope.filter_option[index].state = 0;
            }
            $scope.displayItem = Array();
            for (let index = 0; index < $scope.products.length; index++) {
                $scope.displayItem.push($scope.products[index]);
            }
        }

        $scope.filterItems = function() {

            $scope.displayItem = Array();
            for (let index = 0; index < $scope.products.length; index++) {
                var valid_flag = Array();
                for (let n = 0; n < $scope.filters.length; n++) {
                    valid_flag.push({ id: $scope.filters[n].id, valid_show: -1 });
                }
                for (var j = 0; j < $scope.filter_option.length; j++) {
                    for (let n = 0; n < valid_flag.length; n++) {
                        if (($scope.filter_option[j].state == 1) && ($scope.filter_option[j].parent == valid_flag[n].id) && (valid_flag[n].valid_show == -1)) {
                            valid_flag[n].valid_show = 0;
                        }
                    }
                }

                var tmp_cate = $scope.products[index].category.split(',');
                for (var i = 0; i < tmp_cate.length; i++) {
                    for (var j = 0; j < $scope.filter_option.length; j++) {
                        if (tmp_cate[i].trim() == $scope.filter_option[j].id) {
                            if ($scope.filter_option[j].state == 1) {
                                for (let n = 0; n < valid_flag.length; n++) {
                                    if ($scope.filter_option[j].parent == valid_flag[n].id) {
                                        valid_flag[n].valid_show = 1;
                                    }
                                }
                            }
                        }
                    }
                }
                var _valid_show = 1;
                for (let n = 0; n < valid_flag.length; n++) {
                    _valid_show = _valid_show * valid_flag[n].valid_show;
                }
                if (_valid_show == 1 || _valid_show == -1) {
                    $scope.displayItem.push($scope.products[index]);
                }
            }
        }

        $scope.Base64 = {
            _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
            encode: function(e) {
                var t = "";
                var n, r, i, s, o, u, a;
                var f = 0;
                e = Base64._utf8_encode(e);
                while (f < e.length) {
                    n = e.charCodeAt(f++);
                    r = e.charCodeAt(f++);
                    i = e.charCodeAt(f++);
                    s = n >> 2;
                    o = (n & 3) << 4 | r >> 4;
                    u = (r & 15) << 2 | i >> 6;
                    a = i & 63;
                    if (isNaN(r)) { u = a = 64 } else if (isNaN(i)) { a = 64 }
                    t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
                }
                return t
            },
            decode: function(e) {
                var t = "";
                var n, r, i;
                var s, o, u, a;
                var f = 0;
                e = e.replace(/[^A-Za-z0-9+/=]/g, "");
                while (f < e.length) {
                    s = this._keyStr.indexOf(e.charAt(f++));
                    o = this._keyStr.indexOf(e.charAt(f++));
                    u = this._keyStr.indexOf(e.charAt(f++));
                    a = this._keyStr.indexOf(e.charAt(f++));
                    n = s << 2 | o >> 4;
                    r = (o & 15) << 4 | u >> 2;
                    i = (u & 3) << 6 | a;
                    t = t + String.fromCharCode(n);
                    if (u != 64) { t = t + String.fromCharCode(r) }
                    if (a != 64) { t = t + String.fromCharCode(i) }
                }
                t = Base64._utf8_decode(t);
                return t
            },
            _utf8_encode: function(e) {
                e = e.replace(/rn/g, "n");
                var t = "";
                for (var n = 0; n < e.length; n++) {
                    var r = e.charCodeAt(n);
                    if (r < 128) { t += String.fromCharCode(r) } else if (r > 127 && r < 2048) {
                        t += String.fromCharCode(r >> 6 | 192);
                        t += String.fromCharCode(r & 63 | 128)
                    } else {
                        t += String.fromCharCode(r >> 12 | 224);
                        t += String.fromCharCode(r >> 6 & 63 | 128);
                        t += String.fromCharCode(r & 63 | 128)
                    }
                }
                return t
            },
            _utf8_decode: function(e) {
                var t = "";
                var n = 0;
                var c1, c2, c3;
                var r = c1 = c2 = 0;
                while (n < e.length) {
                    r = e.charCodeAt(n);
                    if (r < 128) {
                        t += String.fromCharCode(r);
                        n++
                    } else if (r > 191 && r < 224) {
                        c2 = e.charCodeAt(n + 1);
                        t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                        n += 2
                    } else {
                        c2 = e.charCodeAt(n + 1);
                        c3 = e.charCodeAt(n + 2);
                        t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                        n += 3
                    }
                }
                return t
            }
        }

        $scope.filters = [];
        $scope.products = [];
        $scope.displayItem = [];

        $timeout(function() {
            this.rowCollection = [];
            var api_url = "lib/product.php";
            var fd = new FormData();
            fd.append('action', 'get');
            var _this = this;
            $http.post(api_url, fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).success(function(data) {
                $scope.filters = data.filter;
                for (let index = 0; index < $scope.filters.length; index++) {
                    $scope.filter_option.push({ id: $scope.filters[index].id, parent: $scope.filters[index].parent, state: 0 });
                    for (let idx = 0; idx < $scope.filters[index].sub.length; idx++) {
                        $scope.filter_option.push({ id: $scope.filters[index].sub[idx].id, parent: $scope.filters[index].sub[idx].parent, state: 0 });
                    }
                }
                console.log($scope.filters);
                $scope.products = data.product;
                $scope.displayItem = $scope.products;
            }).error(function(err) {
                console.log(err);
            });

        }.bind(this), 100);

        $scope.showItem = false;
        $scope.curProduct = [];
        $scope.itemImages = [];
        $scope.viewItem = function(id) {
            console.log(id);
            $scope.showItem = true;
            var api_url = "lib/getProductDetail.php";
            var fd = new FormData();
            fd.append('id', id);
            var _this = this;
            $http.post(api_url, fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            }).success(function(data) {
                $scope.curProduct = data;
                if ($scope.curProduct['image'] != "undefined") {
                    $scope.itemImages = $scope.curProduct['image'].split(',');
                }
                console.log($scope.curProduct);
            }).error(function(err) {
                console.log(err);
            });
        }

        $scope.backToList = function() {
            $scope.showItem = false;
        }

        $scope.gotoMain = function() {
            $scope.backToList();
        }

        $scope.initJQuery = function() {
            $(function() {
                var limit_height = $(document).height() - 240;
                var limit_width = $(document).width() - 240;
                var hide_elem_list = document.getElementsByClassName('item_hide');
                $('.item').live('mouseover mouseout', function(event) {
                    var item_index = $('.item').index(this);
                    var hide_elem = hide_elem_list[item_index];
                    var offset = $(this).offset();
                    var top = offset.top - $(window).scrollTop();
                    var left = offset.left;
                    if (event.type == 'mouseover') {
                        hide_elem.classList.remove('display-none');
                        var off_top = top - 44;
                        if (off_top <= 0) {
                            off_top = 15;
                        }
                        if (off_top >= limit_height) {
                            off_top = limit_height - 15;
                        }
                        var off_left = left - 44;
                        if (off_left <= 0) {
                            off_left = 15;
                        }
                        if (off_left >= limit_width) {
                            off_left = limit_width - 15;
                        }
                        hide_elem.setAttribute('style', 'position: fixed; top: ' + off_top + 'px; left: ' + off_left + 'px; z-index: 9999;');
                        hide_elem.classList.add('zoom');
                        for (let index = 0; index < hide_elem_list.length; index++) {
                            if (index != item_index) {
                                hide_elem_list[index].classList.remove('zoom');
                                hide_elem_list[index].classList.remove('display-none');
                                hide_elem_list[index].classList.add('display-none');
                                document.getElementsByClassName('item')[index].removeAttribute("style");
                            }
                        }
                    }
                    if (event.type == 'mouseout') {
                        for (let index = 0; index < hide_elem_list.length; index++) {
                            if (index != item_index) {
                                hide_elem_list[index].classList.remove('zoom');
                                hide_elem_list[index].classList.remove('display-none');
                                hide_elem_list[index].classList.add('display-none');
                                document.getElementsByClassName('item')[index].removeAttribute("style");
                            }
                        }
                    }
                });

                $(".item_hide").live('mouseout', function(event) {
                    var item_index = $('.item_hide').index(this);
                    var hide_elem = hide_elem_list[item_index];
                    hide_elem.classList.remove('zoom');
                    hide_elem.classList.remove('display-none');
                    hide_elem.classList.add('display-none');
                    hide_elem.removeAttribute("style");
                });

                $(".collection-1").load(function() {
                    alert("fff");
                    $('#carousel').flexslider({
                        animation: "slide",
                        controlNav: false,
                        animationLoop: false,
                        slideshow: false,
                        itemWidth: 64,
                        itemMargin: 0,
                        asNavFor: '#slider'
                    });

                    $('#slider').flexslider({
                        animation: "slide",
                        controlNav: false,
                        animationLoop: false,
                        slideshow: false,
                        sync: "#carousel"
                    });
                });

                // $('#carousel').flexslider({
                //     animation: "slide",
                //     controlNav: false,
                //     animationLoop: false,
                //     slideshow: false,
                //     itemWidth: 64,
                //     itemMargin: 0,
                //     asNavFor: '#slider'
                // });

                // $('#slider').flexslider({
                //     animation: "slide",
                //     controlNav: false,
                //     animationLoop: false,
                //     slideshow: false,
                //     sync: "#carousel"
                // });
            });
        }

        $scope.initJQuery();

        // collection1
        $scope.prod1 = { imagePaths: [] };
        $scope.prod1.imagePaths = [
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aa1d373e4966b4fddb560c3/1520554872453/shoot1_raf_-1.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aa1d373e4966b4fddb560c3/1520554872453/shoot1_raf_-1.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aa1d341f9619aab0142a19b/1520554822276/shoot1_raf_-1-2.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aa1d341f9619aab0142a19b/1520554822276/shoot1_raf_-1-2.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5ac2f4850e2e722b0649fba1/1522726025961/shoot1_raf_-17.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5ac2f4850e2e722b0649fba1/1522726025961/shoot1_raf_-17.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aa1d35853450ad3c9649ef9/1520554849998/shoot1_raf_-7.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aa1d35853450ad3c9649ef9/1520554849998/shoot1_raf_-7.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa93d88251b4d1607c5a6/1525655897577/RAF01-14.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa93d88251b4d1607c5a6/1525655897577/RAF01-14.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa93d2b6a281d80cfe937/1525655893868/RAF01-30.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa93d2b6a281d80cfe937/1525655893868/RAF01-30.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa95103ce6458686cf6b6/1525655917410/RAF01-32.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa95103ce6458686cf6b6/1525655917410/RAF01-32.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa953f950b7632494b7fc/1525655915440/RAF01-35.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa953f950b7632494b7fc/1525655915440/RAF01-35.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa96570a6ad6e397d01dd/1525655925097/RAF01-3.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aa1d31cf9619aab01429bcf/5aefa96570a6ad6e397d01dd/1525655925097/RAF01-3.jpg' }
        ];

        // collection2
        $scope.prod2 = { imagePaths: [] };
        $scope.prod2.imagePaths = [
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f013352f533cbdc377a8/1522724890827/09130015.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f013352f533cbdc377a8/1522724890827/09130015.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f018562fa73cd88e9067/1522724892954/09130017.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f018562fa73cd88e9067/1522724892954/09130017.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f0142b6a284b3fd36590/1522726487161/09130016.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f0142b6a284b3fd36590/1522726487161/09130016.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f3422b6a284b3fd3e098/1522725704992/IMG_8279.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f3422b6a284b3fd3e098/1522725704992/IMG_8279.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f0101ae6cf15a4b819f3/1522724895932/09120030.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f0101ae6cf15a4b819f3/1522724895932/09120030.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f01003ce6421fdb78302/1522724887215/09120038.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f01003ce6421fdb78302/1522724887215/09120038.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f342aa4a99295f396bcb/1522726470437/IMG_8268.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f342aa4a99295f396bcb/1522726470437/IMG_8268.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f33f0e2e722b0649ca9f/1522725701848/IMG_8239.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f33f0e2e722b0649ca9f/1522725701848/IMG_8239.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f33ff950b78f601f2788/1522725703241/IMG_8215.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f010aa4a99295f38edf5/5ac2f33ff950b78f601f2788/1522725703241/IMG_8215.JPG' }
        ];
        // collection3
        $scope.prod3 = { imagePaths: [] };
        $scope.prod3.imagePaths = [
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f103ce6421fdb7caa8/1525660507531/09120011.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f103ce6421fdb7caa8/1525660507531/09120011.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f40e2e722b06499894/1522725376750/09120012.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f40e2e722b06499894/1522725376750/09120012.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f503ce6421fdb7cb37/1522725372442/09120013.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f503ce6421fdb7cb37/1522725372442/09120013.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5aefa9142b6a281d80cfe2ae/1525660514632/41520016.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5aefa9142b6a281d80cfe2ae/1525660514632/41520016.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f9f950b78f601ef48b/1522725378954/09120020.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f9f950b78f601ef48b/1522725378954/09120020.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f1352f533cbdc3bd66/1525660510104/09120001.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1f1352f533cbdc3bd66/1525660510104/09120001.JPG' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1fa70a6ad24dfa47059/1522725379057/09120023.JPG', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5ac2f1f1575d1f44459fca75/5ac2f1fa70a6ad24dfa47059/1522725379057/09120023.JPG' }
        ];

        // collection4
        $scope.prod4 = { imagePaths: [] };
        $scope.prod4.imagePaths = [
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb88f70a6ad6e397f4b15/1525659806208/RAF01-11.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb88f70a6ad6e397f4b15/1525659806208/RAF01-11.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb89603ce6458686f37e0/1525659812048/RAF01-12.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb89603ce6458686f37e0/1525659812048/RAF01-12.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb89e2b6a281d80d23414/1525659863951/RAF01-17.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb89e2b6a281d80d23414/1525659863951/RAF01-17.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8a5562fa779ed08508a/1525659864105/RAF01-23.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8a5562fa779ed08508a/1525659864105/RAF01-23.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8af562fa779ed0851f7/1525659863949/RAF01-43.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8af562fa779ed0851f7/1525659863949/RAF01-43.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8bd03ce6458686f3db0/1525659864105/RAF01-51.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8bd03ce6458686f3db0/1525659864105/RAF01-51.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8c970a6ad6e397f52be/1525659865605/RAF01-57.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8c970a6ad6e397f52be/1525659865605/RAF01-57.jpg' },
            { custom: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8d370a6ad6e397f5499/1525659866099/RAF01-14+%281%29.jpg', thumbnail: 'https://static1.squarespace.com/static/5a51080532601e936558a1a0/5aefb88f562fa779ed084dce/5aefb8d370a6ad6e397f5499/1525659866099/RAF01-14+%281%29.jpg' }
        ];

    })
    .config(function($stateProvider) {

        var gridviewState = {
            name: 'gridview',
            url: '/',
            templateUrl: 'gridview.html'
        }

        var collectionState1 = {
            name: 'collection1',
            url: '/collection1',
            templateUrl: 'collection1.html'
        }

        var collectionState2 = {
            name: 'collection2',
            url: '/collection2',
            templateUrl: 'collection2.html'
        }

        var collectionState3 = {
            name: 'collection3',
            url: '/collection3',
            templateUrl: 'collection3.html'
        }

        var collectionState4 = {
            name: 'collection4',
            url: '/collection4',
            templateUrl: 'collection4.html'
        }

        var collectionState5 = {
            name: 'collection5',
            url: '/collection5',
            templateUrl: 'collection5.html'
        }

        $stateProvider.state(gridviewState);
        $stateProvider.state(collectionState1);
        $stateProvider.state(collectionState2);
        $stateProvider.state(collectionState3);
        $stateProvider.state(collectionState4);
        $stateProvider.state(collectionState5);
    })
    .config(["$locationProvider", function($locationProvider) {
        $locationProvider.html5Mode(true);
    }]);