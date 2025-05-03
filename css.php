<style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
        }
        
        /* Horizontal Sidebar/Navbar */
        .horizontal-sidebar {
            background: #333;
            overflow: hidden;
            position: fixed; /* Makes it stick to the top */
            top: 0;
            width: 100%;
        }
        
        .horizontal-sidebar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        
        .horizontal-sidebar a:hover {
            background-color: #ddd;
            color: black;
        }
        
        .horizontal-sidebar a.active {
            background-color: #4CAF50;
            color: white;
        }
        
        /* Page content - push down content so it doesn't overlap */
        .content {
            margin-top: 60px;
            padding: 20px;
        }
        
        /* Responsive - stack links vertically on small screens */
        @media screen and (max-width: 600px) {
            .horizontal-sidebar a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background-color: #333;
            color: white;
            padding: 12px 16px;
            text-align: left;
        }
        
        td {
            padding: 10px 16px;
            border-bottom: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e9e9e9;
        }
        
        .active-row {
            background-color: #4CAF50;
            color: white;
        }
        .content {
            margin-top: 60px;
            padding: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Form styles to match the theme */
        .form-title {
            color: #333;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        select {
            height: 40px;
            background-color: white;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .required:after {
            content: " *";
            color: red;
        }
    </style>