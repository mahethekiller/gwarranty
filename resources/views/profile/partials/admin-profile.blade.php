 <div class="col-md-12 col-xl-12">

     <div class="card">
         <div class="row">
             <div class="col-md-12 col-xl-6">
                 <div class="card-body">

                     <table class="table table-striped table-bordered">
                         <tbody>
                             <tr>
                                 <th>Name: </th>
                                 <td>{{ Auth::user()->name }}</td>
                             </tr>
                             <tr>
                                 <th>Email: </th>
                                 <td>{{ Auth::user()->email }}</td>
                             </tr>
                             <tr>
                                 <th>Phone Number: </th>
                                 <td>{{ Auth::user()->phone_number }}</td>
                             </tr>
                             <tr>
                                 <th>Full Address: </th>
                                 <td>{{ Auth::user()->address }}</td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>




             <div class="col-md-12 col-xl-6">
                 <div class="card-body">

                     <table class="table table-striped table-bordered">
                         <tbody>
                             <tr>
                                 <th style="width: 50%;">State: </th>
                                 <td>{{ Auth::user()->state }}</td>
                             </tr>
                             <tr>
                                 <th>City: </th>
                                 <td>{{ Auth::user()->city }}</td>
                             </tr>
                             <tr>
                                 <th>Pincode: </th>
                                 <td>{{ Auth::user()->pincode }}</td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
