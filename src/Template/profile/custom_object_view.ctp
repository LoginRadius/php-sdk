<div class="section-main section-minimal">
            <center>
                <div id="customobj-container">
                    <center><table>
                            <tr><th colspan="2">Create</th></tr>
                            <tr><td>Object Name: </td><td><input name="objectname" type='text' id='user-createcustomobj-objectname'/></td></tr>
                            <tr><td>Data: </td><td>
                                    <textarea row="6" cols="25" id="user-createcustomobj-data"></textarea>
                                </td></tr>
                        </table></center>
                    <button id="btn-user-createcustomobj">Create</button><br/>
                    <span style="color:red" id="user-createcustomobj-errorMsg"></span>
                    <span style="color:green" id="user-createcustomobj-successMsg"></span>
                    <br></br>

                    <center><table>
                            <tr><th colspan="2">Update</th></tr>
                            <tr><td>Object Name: </td><td><input name="objectname" type='text' id='user-updatecustomobj-objectname'/></td></tr>
                            <tr><td>Object Record ID: </td><td><input name="objectrecordid" type='text' id='user-updatecustomobj-objectrecordid'/></td></tr>
                            <tr><td>Data: </td><td><textarea row="6" cols="25" id="user-updatecustomobj-data"></textarea></td></tr>
                        </table></center>
                    <button id="btn-user-updatecustomobj">Update</button><br/>
                    <span style="color:red" id="user-updatecustomobj-errorMsg"></span>
                    <span style="color:green" id="user-updatecustomobj-successMsg"></span>
                    <br></br>

                    <center><table>
                            <tr><th colspan="2">Delete</th></tr>
                            <tr><td>Object Name: </td><td><input name="objectname" type='text' id='user-deletecustomobj-objectname'/></td></tr>
                            <tr><td>Object Record ID: </td><td><input name="objectrecordid" type='text' id='user-deletecustomobj-objectrecordid'/></td></tr>
                        </table></center>
                    <button id="btn-user-deletecustomobj">Delete</button><br/>
                    <span style="color:red" id="user-deletecustomobj-errorMsg"></span>
                    <span style="color:green" id="user-deletecustomobj-successMsg"></span>
                    <br></br>

                    <b>Read</b><br/>
                    Object Name: <input name="objectname" type='text' id='user-getcustomobj-objectname'/><br/>
                    <button id="btn-user-getcustomobj">Fetch Data</button><br/>
                    <span style="color:red" id="user-getcustomobj-errorMsg"></span>
                    <br/><br/><br/>
                    <table id="customobj-table" class="table-style"></table>
                    <br/>
                </div>
            </center>                
        </div>     