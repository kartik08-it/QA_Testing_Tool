<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Defects Report - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.reports.index', $project) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Defect Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Defect Statistics</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-3xl font-bold text-gray-900">{{ $defectStats['total'] }}</div>
                            <div class="text-sm text-gray-600 mt-2">Total Defects</div>
                        </div>
                        
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-3xl font-bold text-red-600">{{ $defectStats['open'] }}</div>
                            <div class="text-sm text-gray-600 mt-2">Open</div>
                        </div>
                        
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-3xl font-bold text-blue-600">{{ $defectStats['in_progress'] }}</div>
                            <div class="text-sm text-gray-600 mt-2">In Progress</div>
                        </div>
                        
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-3xl font-bold text-green-600">{{ $defectStats['resolved'] }}</div>
                            <div class="text-sm text-gray-600 mt-2">Resolved</div>
                        </div>
                        
                        <div class="text-center p-4 bg-gray-100 rounded-lg">
                            <div class="text-3xl font-bold text-gray-700">{{ $defectStats['closed'] }}</div>
                            <div class="text-sm text-gray-600 mt-2">Closed</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Defects by Severity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Defects by Severity</h3>
                    
                    @if($defectsBySeverity->count() > 0)
                        <div class="space-y-4">
                            @foreach(['critical', 'high', 'medium', 'low'] as $severity)
                                @php
                                    $count = $defectsBySeverity[$severity] ?? 0;
                                    $total = $defectsBySeverity->sum();
                                    $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                    
                                    $colors = [
                                        'critical' => ['bg' => 'bg-red-500', 'text' => 'text-red-600'],
                                        'high' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-600'],
                                        'medium' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-600'],
                                        'low' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-600']
                                    ];
                                @endphp
                                
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold capitalize {{ $colors[$severity]['text'] }}">
                                            {{ $severity }}
                                        </span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-600">{{ $count }} defects</span>
                                            <span class="font-bold {{ $colors[$severity]['text'] }}">
                                                {{ round($percentage, 1) }}%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="{{ $colors[$severity]['bg'] }} h-3 rounded-full" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">No defects reported yet.</p>
                    @endif
                </div>
            </div>

            <!-- Defect Trends -->
            @if($defectTrends->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Defect Trends (Last 30 Days)</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Defects Reported</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($defectTrends as $trend)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm font-medium">
                                                {{ \Carbon\Carbon::parse($trend->date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="font-bold text-red-600">{{ $trend->count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>