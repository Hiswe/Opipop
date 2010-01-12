var Job =
{
    currentJobs : 0,

    addJob : function()
    {
        Job.currentJobs ++;
        Job.updateLoading();
    },

    endJob : function()
    {
        Job.currentJobs --;
        if (Job.currentJobs < 0)
        {
            Job.currentJobs = 0;
        }
        Job.updateLoading();
    },

    working : function()
    {
        return (Job.currentJobs != 0);
    },

    jobsDone : function()
    {
        return (Job.currentJobs == 0);
    },

    updateLoading : function()
    {
        if (Job.currentJobs == 0)
        {
            $('working').hide();
        }
        else
        {
            $('working').show();
        }
    }
};
