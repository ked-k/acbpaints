<x-general-layout>
       <!-- start page title -->
       <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User Logs</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>     
   
    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">System User Logs</h4> 
                            </div>                                        
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    
                        <div class="table-responsive">
                            <table id="datableButtons" class="table w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                        <th>Platform</th>
                                        <th>Browser</th>
                                        <th>Client_IP</th>
                                        <th>Mac-Address</th>
                                        <th>Period</th>
                                        <th>Activity Date/time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $key => $log)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$log->email}}</td>
                                        <td>{{$log->description}}</td>
                                        <td>{{$log->platform}}</td> 
                                        <td>{{$log->browser}}</td>
                                        <td>{{$log->client_ip}}</td>
                                        <td>{{$log->mac}}</td>
                                        <td>{{$log->created_at->diffForHumans()}}</td>
                                        <td>{{$log->created_at}}</td>
                                    </tr>
                                    {{-- 'H:i:s' --}}
                                    @endforeach                                                  
                                </tbody>
                            </table>                                          
                        </div> <!-- end preview-->
                    
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    
</x-general-layout>