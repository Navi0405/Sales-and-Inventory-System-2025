<?php

include_once('../../config/database.php');
include_once('../model/Category.php');

$action = $_GET['action'];
$Category = new Category($conn);

switch ($action)
{
    case 'getTableData':
    
        $result = $Category->getAll();

        $table_data = '';
        $counter = 1;
        foreach ($result as $category) {
            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';
            $table_data .= '<td><span class="category">'  . $category['name'] . '</span></td>';
            $table_data .= '<td class="col-actions">';
            $table_data .= '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
            $table_data .= '<button type="button" onclick="Category.clickUpdate('. $category['id'] .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Update </button>';
            // if($_SESSION['user']['role'] == 1) {
            //     $table_data .= '<button type="button" onclick="Category.clickDelete('. $category['id'] .')" class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i> Delete</button>';
            // }
            $table_data .= '</div>';
            $table_data .= '</td>';
            $table_data .= '</tr>';

            $counter++;
        }

        echo json_encode($table_data);
    
    break;

    case 'getSelectData':
    
        $result = $Category->getAll();

        $options = '<option value="" selected="true" disabled>Select Category</option>';

        foreach ($result as $category) 
        {
            $options .= '<option value='. $category['id'] .'>' . $category['name'] . '</option>';
        }

        echo json_encode($options);
    
    break;

    case 'getById':
    
        $category_id = $_POST['category_id'];

        echo json_encode($Category->getById($category_id));
    
    break;

    case 'save':
    
        $category_name = $_POST['category_name'];

        $request = [
            'name' => $category_name
        ];

        $result = $Category->save($request);

        echo json_encode($result);

    break;

    case 'update':
    
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];

        $request = [
            'id' => $category_id,
            'name' => $category_name,
        ];

        $result = $Category->update($request);

        echo json_encode($result);
    
    break;

    // case 'delete':
    
    //     $category_id = $_POST['category_id'];

    //     $result = $Category->delete($category_id);

    //     echo json_encode($result);
    
    // break;

    case 'getCategoryPerMonthReport':
    
        $colors = ['#4682B4', '#FFE4C4','#A9A9A9', '#CD5C5C', '#FFA07A', '#FFE4B5', '#E6E6FA', '#90EE90', '#E0FFFF', '#2E8B57', '#9370DB', '#FFDAB9'];

        $data = $Category->getReportLastSixMonths();

        $dates = [];
        $chart_label = [];
        for($x=5; $x>=0 ;$x--) {
            $month_num = date("Y-m", strtotime("-$x months"));
            $month_name = date("F", strtotime("-$x months"));

            $dates[] = [
                'month' => $month_num,
                'label' => $month_name
            ];

            $chart_label[] = $month_name;
        }

        $categories = [];
        foreach($data as $report_data)
        {
            $category = $report_data['category_name'];
            if(!in_array($category, $categories)){
                $categories[] = $category;
            }
        }

        $chart_dataset = [];
        $x=0;
        foreach($categories as $category)
        {
            $chart_data = [];
            foreach ($dates as $date) 
            {
                $value = 0;
                foreach($data as $report_data) 
                {
                    if($category == $report_data['category_name'] && $date['month'] == $report_data['month'])
                    {
                        $value = $report_data['total'];
                    }
                }
                $chart_data[] = $value;
            }

            $chart_dataset[] = [
                'label' => $category,
                'backgroundColor' => $colors[$x],
                'borderColor' => $colors[$x],
                'pointRadius' => false,
                'pointColor' => $colors[$x],
                'pointStrokeColor' => $colors[$x],
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => $colors[$x],
                'data' => $chart_data,
            ];
            $x++;
        }

        $chartData = [
            'labels' => $chart_label,
            'datasets' => $chart_dataset
        ];
        
        echo json_encode($chartData);
    break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        
}