<li class="list-group-item border-0 mb-4 bg-transparent p-0 text-muted">
    <div class="d-flex flex-row">
        <div class="flex-shrink-1 pr-4">
            <div class="d-flex flex-column">
                <div>
                    <span class="font-weight-bolder">
                        {{ $field }}
                    </span>
                </div>
                <div>
                    {{ $value }}
                </div>
            </div>
        </div>
        
        <div class="flex-grow-1">
            <div class="d-flex justify-content-end h-100">
                <div class="d-flex align-items-center">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
    </div>
    
</li>
