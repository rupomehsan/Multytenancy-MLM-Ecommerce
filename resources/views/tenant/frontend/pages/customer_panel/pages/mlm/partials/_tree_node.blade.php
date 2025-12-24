{{-- 
    Recursive Tree Node Component
    Renders a single node and its children recursively
    
    Required variables:
    - $node: Array containing node data (id, name, email, level, children, etc.)
    - $depth: Current depth level (for limiting recursion)
--}}

<div class="mlm-tree-node">
    <div class="mlm-tree-node-content {{ $node['level'] == 0 ? 'root' : '' }}">
        {{-- Avatar --}}
        <div class="mlm-node-avatar">
            @if (isset($node['image']) && $node['image'])
                <img src="{{ asset($node['image']) }}" alt="{{ $node['name'] }}">
            @else
                {{ strtoupper(substr($node['name'], 0, 1)) }}
            @endif
        </div>

        {{-- Level Badge --}}
        <div class="mlm-node-level">
            @if ($node['level'] == 0)
                You (Root)
            @else
                Level {{ $node['level'] }}
            @endif
        </div>

        {{-- User Info --}}
        <div class="mlm-node-name">{{ $node['name'] }}</div>
        <div class="mlm-node-email">{{ $node['email'] }}</div>

        {{-- Statistics --}}
        <div class="mlm-node-stats">
            <div class="mlm-node-stat">
                <div class="mlm-node-stat-value">{{ $node['direct_count'] }}</div>
                <div class="mlm-node-stat-label">Direct</div>
            </div>
            <div class="mlm-node-stat">
                <div class="mlm-node-stat-value">{{ $node['total_team_count'] }}</div>
                <div class="mlm-node-stat-label">Team</div>
            </div>
        </div>

        {{-- Join Date --}}
        <div class="mlm-node-date">
            <i class="fi-rr-calendar"></i> Joined {{ $node['joined_at'] }}
        </div>

        {{-- Expand/Collapse Button (only if has children) --}}
        @if (count($node['children']) > 0)
            <div class="mlm-expand-btn expanded" data-node="{{ $node['id'] }}"></div>
        @endif
    </div>

    {{-- Render Children Recursively --}}
    @if (count($node['children']) > 0 && $depth < 3)
        <div class="mlm-tree-children" id="children-{{ $node['id'] }}">
            @foreach ($node['children'] as $child)
                @include('tenant.frontend.pages.customer_panel.pages.mlm.partials._tree_node', [
                    'node' => $child,
                    'depth' => $depth + 1,
                ])
            @endforeach
        </div>
    @endif
</div>
