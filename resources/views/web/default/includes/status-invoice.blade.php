<span class="font-12 font-weight-500">
    @if ($status == 'Cancelado' or $status == 'Recusado')
    <span style="width: 90px; height: 20px;" class="badge badge-danger">{{$status}}</span>
    @elseif ($status == 'Pendente')
    <span style="width: 90px; height: 20px;" class="badge badge-secondary">{{$status}}</span>
    @elseif ($status == 'Recebido' or $status == 'Confirmado' or $status == 'Pago')
    <span style="width: 90px; height: 20px;" class="badge badge-primary">{{$status}}</span>
    @elseif ($status == 'Vencido')
    <span style="width: 90px; height: 20px;" class="badge badge-warning">{{$status}}</span>
    @endif
</span>
