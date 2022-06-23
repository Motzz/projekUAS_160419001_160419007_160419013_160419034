<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/home" class="brand-link">
    <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Apotiku</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">
           @if(Auth::user())
                      {{Auth::user()->name}}
                   
        </a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        
       
 @if(Auth::user()->role == "admin")
        <li class="nav-header">REPORT</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p> Obat 
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/medicinesTerlaris')}}" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                  Obat Terlaris
                </p>
              </a>
            </li>

           
          </ul>
        </li>

          <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>Customer
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/userTerbanyakBeli')}}" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                  Customer Teraktif
                </p>
              </a>
            </li>

           
          </ul>
        </li>
         <!-- Start Pengaturan-->

          <li class="nav-header">RIWAYAT</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p> Pembelian
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('transaction.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                       Pembelian Semua Customer
                    </p>
                  </a>
                </li>

              </ul>
            </li>

        </li>
        <!-- END Pengaturan-->
        <!-- Start Pengaturan-->

          <li class="nav-header">PENGATURAN STOK</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p> Stok Awal Barang 
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('stokAwal.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                      List Stok Awal Barang
                    </p>
                  </a>
                </li>

              </ul>
            </li>

        </li>
        <!-- END Pengaturan-->

         <!-- Start Penyesuaian-->

          <li class="nav-header">PENYESUAIAN STOK</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p> Stok Barang 
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('adjustmentStok.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                      List PenyesuaianStok Barang
                    </p>
                  </a>
                </li>

                
              </ul>
            </li>

         
        </li>
        <!-- END Penyesuaian-->

        

        <li class="nav-header">MASTER</li>
       
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>
                  Medicine
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('medicines.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>list Medicine</p>
                  </a>
                </li>
              </ul>
              

              <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>
                  Category
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('categories.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>list Category</p>
                  </a>
                </li>
              </ul>

               <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>
                  User
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('users.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>list User</p>
                  </a>
                </li>
              </ul>
        </li>
        <!--End Menu-->
   @elseif(Auth::user()->role == "buyer")
    <li class="nav-header">-</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>  Pembelian Barang  
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('transaction.index')}}" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                   List Riwayat Pembelian Barang
                </p>
              </a>
            </li>

           
          </ul>
        </li>

          <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>Katalog Obat
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('/')}}" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>
                  List-Obat
                </p>
              </a>
            </li>

           
          </ul>
        </li>

        
        
             
        @endif

  @endif 
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>