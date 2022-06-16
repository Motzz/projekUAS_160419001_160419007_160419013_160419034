


<div class="modal-header">
  <h4 class="modal-title">{{$data->generic_name}} {{$data->form}}</h4>
</div>
<div class="modal-body">
  <h2>Medicines detail</h2>
  <table class="table">
      <thead>
        <tr>
          <th>Data</th>
          <th>Hasil</th>

        </tr>
      </thead>
      <tbody>
      
        <tr>
          <td>generic name</td>
          <td>{{$data->generic_name}}</td>
      </tr>
      <tr>
          <td>formula</td>
          <td>{{$data->form}}</td>
      </tr>
      <tr>
          <td>restriction</td>
          <td>{{$data->restriction_formula}}</td>
      </tr>
      <tr>
          <td>harga</td>
          <td>{{$data->price}}</td>
      </tr>
      <tr>
          <td>kategori</td>
          <td>{{$data->category->name}}</td>
      </tr>
      <tr>
          <td>foto</td>
          <td><img src="{{asset('images/'.$data->image)}}" alt=""></td>
      </tr>
          
          
        </tr>
    
      </tbody>
    </table>
<div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>



</div>

