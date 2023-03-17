<span class="font-12 font-weight-500">
    @if ($status == 'Cancelado' or $status == 'Recusado')
    <span class="badge badge-danger">{{$status}}</span>
    @elseif ($status == 'Pendente')
    <span class="badge badge-secondary">{{$status}}</span>
    @elseif ($status == 'Recebido' or $status == 'Confirmado' or $status == 'Pago')
    <span class="badge badge-primary">{{$status}}</span>
    @elseif ($status == 'Vencido')
    <span class="badge badge-warning">{{$status}}</span>
    @endif
</span>
